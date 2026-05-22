let laporanId = null;

let reconnectToken = null;

let gpsAktif = false;

let watchId = null;

let sedangMengirim = false;

let laporanTerkirim = false;

/*
========================================
MAP
========================================
*/

const map = L.map('map').setView(
[-8.650000,115.216667],
13
);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

let markerPelapor = null;

let markerPolisi = null;

let routeLine = null;

/*
========================================
GPS CHECK
========================================
*/

window.onload = function(){

    cekGPS();

}

/*
========================================
CEK GPS
========================================
*/

function cekGPS(){

    navigator.geolocation.getCurrentPosition(

        function(position){

            gpsAktif = true;

            document
            .getElementById(
                'gpsStatus'
            )
            .innerHTML =

            '<i class="fa-solid fa-circle-check"></i> GPS Aktif';

        },

        function(){

            gpsAktif = false;

            alert(
            'WAJIB mengaktifkan GPS'
            );

            document
            .getElementById(
                'gpsStatus'
            )
            .innerHTML =

            '<i class="fa-solid fa-triangle-exclamation"></i> GPS Tidak Aktif';

        },

        {

            enableHighAccuracy:true,
            timeout:10000,
            maximumAge:0

        }

    );

}

/*
========================================
AKTIFKAN SOS
========================================
*/

function aktifkanSOS(){

    if(!gpsAktif){

        alert(
        'GPS belum aktif'
        );

        return;

    }

    /*
    ========================================
    CEGAH DOUBLE SOS
    ========================================
    */

    if(laporanTerkirim){

        alert(
        'Laporan SOS sudah aktif'
        );

        return;

    }

    const btn =
    document.getElementById(
        'sosBtn'
    );

    btn.disabled = true;

    btn.innerHTML =

    '<i class="fa-solid fa-spinner fa-spin"></i> SOS Sedang Dikirim';

    btn.classList.add(
        'processing'
    );

    /*
    ========================================
    GPS REALTIME
    ========================================
    */

    watchId =
    navigator.geolocation.watchPosition(

    function(position){

        let latitude =
        position.coords.latitude;

        let longitude =
        position.coords.longitude;

        let speed =
        position.coords.speed || 0;

        speed = speed * 3.6;

        /*
        ========================================
        MARKER PELAPOR
        ========================================
        */

        if(!markerPelapor){

            markerPelapor =
            L.marker([
                latitude,
                longitude
            ])

            .addTo(map)

            .bindPopup(
            'Lokasi Pelapor'
            );

        }else{

            markerPelapor.setLatLng([
                latitude,
                longitude
            ]);

        }

        map.setView([
            latitude,
            longitude
        ],15);

        /*
        ========================================
        ANTI SPAM FETCH
        ========================================
        */

        if(sedangMengirim){
            return;
        }

        sedangMengirim = true;

        /*
        ========================================
        MODE INSERT / UPDATE
        ========================================
        */

        let mode = 'insert';

        if(laporanId !== null){

            mode = 'update';

        }

        /*
        ========================================
        FETCH DATABASE
        ========================================
        */

        fetch(
        'simpan_laporan.php',
        {

            method:'POST',

            headers:{
                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:

            'latitude=' + latitude +

            '&longitude=' + longitude +

            '&speed=' + speed +

            '&laporan_id=' + (laporanId || '') +

            '&reconnect_token=' + (reconnectToken || '') +

            '&mode=' + mode

        })

        .then(response => response.json())

        .then(data => {

            sedangMengirim = false;

            /*
            ====================================
            SUCCESS
            ====================================
            */

            if(data.success){

                /*
                =================================
                INSERT HANYA SEKALI
                =================================
                */

                if(mode == 'insert'){

                    laporanTerkirim = true;

                }

                /*
                =================================
                SIMPAN ID
                =================================
                */

                laporanId =
                data.id;

                reconnectToken =
                data.reconnect_token;

                document
                .getElementById(
                    'status'
                )
                .innerHTML =

                'SOS berhasil dikirim';

            }

            /*
            ====================================
            ERROR
            ====================================
            */

            else{

                document
                .getElementById(
                    'status'
                )
                .innerHTML =

                data.message;

            }

        })

        .catch(error => {

            sedangMengirim = false;

            console.log(error);

        });

    },

    function(error){

        console.log(error);

        alert(
        'GPS gagal diakses'
        );

    },

    {

        enableHighAccuracy:true,
        maximumAge:0,
        timeout:5000

    });

    /*
    ========================================
    STATUS REALTIME
    ========================================
    */

    cekStatus();

}

/*
========================================
STATUS REALTIME
========================================
*/

function cekStatus(){

    setInterval(() => {

        if(!laporanId){
            return;
        }

        fetch(
        'cek_status.php?id='+
        laporanId
        )

        .then(response => response.json())

        .then(data => {

            if(!data){
                return;
            }

            /*
            ========================================
            STATUS
            ========================================
            */

            document
            .getElementById(
                'status'
            )
            .innerHTML =
            data.status;

            /*
            ========================================
            POSISI POLISI
            ========================================
            */

            if(
            data.police_latitude &&
            data.police_longitude
            ){

                let policeLat =
                parseFloat(
                data.police_latitude
                );

                let policeLng =
                parseFloat(
                data.police_longitude
                );

                if(!markerPolisi){

                    markerPolisi =
                    L.marker([
                        policeLat,
                        policeLng
                    ])

                    .addTo(map)

                    .bindPopup(
                    'Posisi Polisi'
                    );

                }else{

                    markerPolisi.setLatLng([
                        policeLat,
                        policeLng
                    ]);

                }

            }

            /*
            ========================================
            SPEED
            ========================================
            */

            document
            .getElementById(
                'policeSpeed'
            )
            .innerHTML =

            parseFloat(
            data.police_speed || 0
            ).toFixed(2);

            /*
            ========================================
            JARAK
            ========================================
            */

            document
            .getElementById(
                'jarakPolisi'
            )
            .innerHTML =

            parseFloat(
            data.jarak_polisi || 0
            ).toFixed(2);

            /*
            ========================================
            ESTIMASI
            ========================================
            */

            document
            .getElementById(
                'estimasiPolisi'
            )
            .innerHTML =

            parseFloat(
            data.estimasi_waktu || 0
            ).toFixed(0);

            /*
            ========================================
            LAPORAN DITERIMA
            ========================================
            */

            if(
            data.status ==
            'Laporan Diterima Polisi'
            ){

                const btn =
                document.getElementById(
                    'sosBtn'
                );

                btn.innerHTML =

                '<i class="fa-solid fa-circle-check"></i> Laporan Diterima Polisi';

                btn.classList.remove(
                    'processing'
                );

                btn.classList.add(
                    'success'
                );

            }

            /*
            ========================================
            MENUJU LOKASI
            ========================================
            */

            if(
            data.status ==
            'Polisi Menuju Lokasi'
            ){

                if(
                markerPelapor &&
                markerPolisi
                ){

                    let pelaporLatLng =
                    markerPelapor.getLatLng();

                    let polisiLatLng =
                    markerPolisi.getLatLng();

                    if(routeLine){

                        map.removeLayer(
                            routeLine
                        );

                    }

                    routeLine =
                    L.polyline([

                        polisiLatLng,
                        pelaporLatLng

                    ],{

                        color:'#2563eb',
                        weight:5

                    })

                    .addTo(map);

                }

            }

            /*
            ========================================
            SELESAI
            ========================================
            */

            if(
            data.status ==
            'Laporan Selesai'
            ){

                const btn =
                document.getElementById(
                    'sosBtn'
                );

                btn.innerHTML =

                '<i class="fa-solid fa-circle-check"></i> Laporan Selesai';

                btn.classList.remove(
                    'processing'
                );

                btn.classList.add(
                    'success'
                );

                if(watchId){

                    navigator.geolocation.clearWatch(
                        watchId
                    );

                }

                if(routeLine){

                    map.removeLayer(
                        routeLine
                    );

                }

            }

        })

        .catch(error => {

            console.log(error);

        });

    },3000);

}

/*
========================================
OFFLINE
========================================
*/

window.addEventListener(
'offline',
function(){

    document
    .getElementById(
        'status'
    )
    .innerHTML =

    'Koneksi terputus... reconnecting';

});

/*
========================================
ONLINE
========================================
*/

window.addEventListener(
'online',
function(){

    document
    .getElementById(
        'status'
    )
    .innerHTML =

    'Koneksi tersambung kembali';

});