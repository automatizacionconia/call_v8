<template>
    <div>
        <v-btn text @click="initMap()">
            <v-icon :color="colorIcon">mdi-map-marker-outline</v-icon>
            {{ descripcion }}
        </v-btn>
        <v-dialog v-model="dialog" max-width="80vw" persistent>
            <v-card>
                <v-toolbar dense dark color="entidad">
                    <v-toolbar-title>GEOREFERENCIAR</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn icon dark @click="cerrar()">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar>
                <v-card-text>
                    <div
                        id="map"
                        class="map"
                        style="margin-top: 15px !important"
                    ></div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn color="entidad" dark @click="confirmar()"
                        ><v-icon left>mdi-map-marker-check-outline</v-icon
                        >CONFIRMAR UBICACIÓN
                    </v-btn>
                    <v-btn outlined color="entidad" dark @click="cancelar()"
                        ><v-icon left>mdi-close</v-icon> CANCELAR</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import L from "leaflet";
export default {
    props: ["lat", "lng"],
    data() {
        return {
            latDefault: -12.063472104584553,
            lngDefault: -77.04197265153208,
            maker: null,
            map: null,
            zoom: 14,
            draggable: true,
            lngLatModel: {
                lat: null,
                lng: null,
            },
            lngLatModelTmp: {
                lat: null,
                lng: null,
            },
            editable: true,
            dialog: false,
            estaGeoreferenciado: false,
        };
    },
    computed: {
        colorIcon() {
            return this.estaGeoreferenciado ? "success" : "red";
        },
        descripcion() {
            return this.estaGeoreferenciado
                ? "GEOREFERENCIADO"
                : "NO GEOREFERENCIADO";
        },
    },
    async mounted() {
        if (this.lat) {
            this.lngLatModel.lat = this.lat;
            this.lngLatModel.lng = this.lng;
            this.estaGeoreferenciado = true;
        }
    },
    methods: {
        async initMap() {
            this.dialog = true;

            await setTimeout(function () {
                window.dispatchEvent(new Event("resize"));
            }, 250);
            /**
             * Datos de mapbox
             */
            let mapboxUrl =
                "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}";
            let mapboxAttribution =
                'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
            let mapboxToken =
                "pk.eyJ1IjoieWF2aWRhbWlhbiIsImEiOiJja2k2dG1ydjQwM2U5MnJxY2VyYjk4eDFuIn0.zR2SMRVQUKYw9D7y7OrFxg";

            /**
             * Estilos de mapa
             */
            let grayscale = L.tileLayer(mapboxUrl, {
                    id: "mapbox/light-v10",
                    attribution: mapboxAttribution,
                    maxZoom: 20,
                    accessToken: mapboxToken,
                }),
                streets = L.tileLayer(mapboxUrl, {
                    id: "mapbox/streets-v11",
                    attribution: mapboxAttribution,
                    maxZoom: 20,
                    accessToken: mapboxToken,
                }),
                emerald = L.tileLayer(mapboxUrl, {
                    id: "mapbox/outdoors-v11",
                    attribution: mapboxAttribution,
                    maxZoom: 20,
                    accessToken: mapboxToken,
                });

            var baseLayers = {
                Normal: emerald,
                "Esc. Grises": grayscale,
                Calles: streets,
            };

            /**
             * Definimos el mapa
             */
            const self = this;

            self.map = L.map("map", {
                center: [this.latDefault, this.lngDefault],
                zoom: this.zoom,
                minZoom: 13,
                maxZoom: 20,
                layers: [emerald],
            });
            /**
             * Se declara el control de las capas a mostrar
             */
            // var layers = L.control.layers(baseLayers,overlayMaps, {collapsed: true});
            var layers = L.control.layers(baseLayers, {}, { collapsed: true });

            layers.addTo(self.map);

            setTimeout(function () {
                self.marker = L.marker(self.getLngLatInicial(), {
                    draggable: self.draggable,
                })
                    .addTo(self.map)
                    .bindPopup(self.isGeoreferenciado(), {
                        autoClose: true,
                        closeOnClick: false,
                    })
                    .openPopup();

                self.marker.on("dragend", function (ev) {
                    self.actualizarLngLatDrag();
                });
            }, 250);

            //
            if (this.editable) {
                self.map.on("click", function (ev) {
                    //alert(ev.latlng); // ev is an event object (MouseEvent in this case)
                    self.actualizarLngLat(ev.latlng);
                });
            }

            let latLng = { lat: self.latDefault, lng: self.lngDefault };

            if (self.lngLatModel.lat != null) {
                latLng = self.lngLatModel;
            }

            self.map.setView(latLng, this.zoom);
        },
        getLngLatInicial() {
            const self = this;
            if (self.lngLatModel.lng != null && self.lngLatModel.lat != null)
                // verifico si en store mapa se se ha georeferenciado
                return [self.lngLatModel.lat, self.lngLatModel.lng];
            else return [self.latDefault, self.lngDefault];
        },
        isGeoreferenciado() {
            const self = this;
            if (self.lngLatModel.lng != null && self.lngLatModel.lat != null)
                return (
                    "Longitud: " +
                    self.lngLatModel.lng +
                    " Latitud: " +
                    self.lngLatModel.lat
                );
            else return "<h3>¡No se ha georeferenciado!</h3>";
        },
        actualizarLngLat(lngLat) {
            const self = this;

            /*const lngLat= self.marker.getLatLng() //obtengo la latitud actual*/
            self.marker
                .setLatLng(lngLat)
                .bindPopup(
                    "Latitud: " + lngLat.lat + " Longitud: " + lngLat.lng,
                    { autoClose: true, closeOnClick: false }
                )
                .openPopup();

            //actualizo el la unicación del mapa en el store
            self.lngLatModelTmp = lngLat;
        },

        actualizarLngLatDrag() {
            const self = this;

            const lngLat = self.marker.getLatLng(); //obtengo la latitud actual*/

            self.marker
                .setLatLng(lngLat)
                .bindPopup(
                    "Longitud: " + lngLat.lng + " Latitud: " + lngLat.lat,
                    { autoClose: true, closeOnClick: false }
                )
                .openPopup();

            //actualizo el la unicación del mapa en el store
            self.lngLatModelTmp = lngLat;
        },
        confirmar() {
            this.map.remove();
            this.$emit("setCoords", this.lngLatModelTmp);
            this.lngLatModel = this.lngLatModelTmp;
            this.estaGeoreferenciado = true;
            this.dialog = false;
        },
        cerrar() {
            this.map.remove();
            this.dialog = false;
        },
        cancelar() {
            this.lngLatModelTmp = {
                lat: null,
                lng: null,
            };
            this.map.remove();
            this.dialog = false;
        },
    },
};
</script>

<style scoped>
.map {
    width: 100%;
    height: 65vh;
    z-index: 1 !important;
}
</style>
