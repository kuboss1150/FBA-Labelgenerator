<?php
// vuejs include
append_js_file('https://cdn.jsdelivr.net/npm/vue@2.6.11');
append_js_file('https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.5.3/vue-router.js');
append_js_file('https://cdn.jsdelivr.net/npm/vuetify@2.2.14');
append_css_file('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900');
append_css_file('https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp');
append_css_file('https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css');
append_css_file('https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css');

//jspdf include
append_js_file('https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js');
// append_js_file('https://unpkg.com/jspdf');

append_js_file('https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js');
append_js_file('https://unpkg.com/jspdf-autotable');
append_js_file('https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js');

// append_js_file('https://cdnjs.cloudflare.com/ajax/libs/encoding-japanese/1.0.30/encoding.min.js');

append_js_file("{$assets_url}lib/tsv.js");
?>

<!-- Shipment list Component -->
<script type="text/x-template" id="shipments_list">
    <v-content>
        <v-overlay :value="loading" :opacity="0.1">
            <v-progress-circular :size="50" :width="5" indeterminate color="deep-purple accent-4"></v-progress-circular>
        </v-overlay>

        <div class="layout input mt-4">
            <v-btn color="primary" class="ma-3" width="150" @click="dialog = true">出庫登録</v-btn>
            <v-spacer></v-spacer>
            <v-text-field v-model="fnsku" label="FNSKU" class="mx-2" @change="getShipments"></v-text-field>
        </div>

        <v-data-table height="500" :fixed-header="true" :hide-default-footer="true" :disable-pagination='true' :headers="headers" :items="shipments" class="elevation-2" >
            <template v-slot:item.id="{ item }">
                <router-link tag="v-btn" class="primary" style="width:50px" :to="'/box/update/'+item.id"><v-icon>visibility</v-icon></router-link>
            </template>
        </v-data-table>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">出庫登録</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field :autofocus="true" :rules="[rules.required]" label="Shipment名" v-model="new_shipment"></v-text-field>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="addShipment">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-content>
</script>
<?php ob_start(); ?>
<script>
    const shipments_list = Vue.component('shipments-list', {
        template: '#shipments_list',
        data() {
            return {
                loading: false,
                dialog: false,
                fnsku: '',
                new_shipment: '',
                shipments: [],
                headers: [{
                        text: 'Shipment名',
                        align: 'left',
                        value: 'shipment_name',
                    },
                    {
                        text: 'アカウント名',
                        value: 'seller_id'
                    },
                    {
                        text: '作成日',
                        value: 'shipment_date'
                    },
                    {
                        text: '',
                        value: 'id',
                        width: 70
                    }
                ],
                rules: {
                    required: value => !!value || 'Required.',
                },
            }
        },
        created() {
            this.getShipments();
        },
        methods: {
            getShipments() {
                this.loading = true;
                axios.post('<?= current_url(); ?>', {
                    fnsku: this.fnsku
                }).then(res => {
                    this.loading = false;
                    this.shipments = res.data;
                });
            },
            addShipment() {
                if (this.new_shipment != '') {
                    axios.post('<?= site_url('store/add_shipment'); ?>', {
                        name: this.new_shipment
                    }).then(res => {
                        this.$router.push('/box/create/'+res.data+'/first');
                        this.dialog = false;
                    });
                }
            }
        },
        mounted() {}
    });
</script>
<?php
    $page_script = ob_get_clean();
    append_js($page_script);
?>
<!-- End Shipment list Component -->

<!-- Shipment Header Component -->
<script type="text/x-template" id="shipment_header">
    <v-content>
        <div class="layout input mt-4">
            <v-text-field v-model="shipment_name" label="Shipment名" @change="shipment_name_update"></v-text-field>
            <v-text-field v-model="shipment_weight" label="Shipment合計重量" class="mx-2" type="number" :readonly="true"></v-text-field>
            <v-text-field v-model="shipment_items_count" label="Shipment合計数量" type="number" :readonly="true"></v-text-field>
            <v-spacer></v-spacer>
            <router-link tag="v-btn" class="ma-3 error" style="width:200px" :to="'/box/create/'+$route.params.shipment_id+'/make'">箱作成</router-link>
            <v-btn color="primary" class="mt-3 mr-3" width="200" @click="tsv">tsvファイル出力</v-btn>
            <v-btn color="info" class="mt-3" width="200" @click="csv">csvファイル出力</v-btn>
        </div>
        <v-divider></v-divider>
        <iframe style="display:none" name="tsv_form"></iframe>
    </v-content>
</script>
<?php ob_start(); ?>
<script>
    const shipment_header = Vue.component('shipment-header', {
        template: '#shipment_header',
        data() {
            return {
                shipment_id: 0,
                shipment_name: '',
                shipment_weight: 0,
                shipment_items_count: 0,
            }
        },
        created() {
            this.shipment_id = this.$route.params.shipment_id;
            http.get(`store/get_shipment/${this.shipment_id}`).then(res => {
                this.shipment_name = res.data.shipment_name;
                this.shipment_weight = res.data.shipment_weight;
                this.shipment_items_count = res.data.shipment_items_count
            });
        },
        methods: {
            tsv() {
                window.open(`/store/export_tsv/${this.shipment_id}`, 'tsv_form');
            },
            csv() {
                window.open(`/store/export_csv/${this.shipment_id}`, 'tsv_form');
            },
            shipment_name_update() {
                if(this.shipment_name!=''){
                    http.post(`store/shipment_name_update/${this.shipment_id}`, {
                        shipment_name: this.shipment_name,
                    }).then(res => {
                        console.log(res);
                    });
                }
            }
        }
    });
</script>
<?php
    $page_script = ob_get_clean();
    append_js($page_script);
?>
<!-- End Shipment Header Component -->

<!-- Box Item Component -->
<script type="text/x-template" id="box_item">

    <v-form ref="form">
        <v-row justify="space-between">
            <v-col cols="12" md="3">
                <v-text-field v-model="box_name" label="箱名前"  :rules="[rules.required]" ></v-text-field>
                <v-text-field v-model="weight" type="number" label="重量" :rules="[rules.required]" ></v-text-field>
                <v-text-field v-model="total_quantity" label="箱合計数量" :readonly="true"></v-text-field>
            </v-col>
            <v-col cols="12" md="7">
                <div class="layout input" v-for="(item, index) in items">
                    <v-text-field :error="item.error" :rules="[rules.required]"  v-model="item.fnsku" label="FNSKU" @change="getSku(index)"></v-text-field>
                    <v-text-field :error="item.error" :rules="[rules.sku]"  v-model="item.sku" label="SKU" class="mx-2" :readonly="true"></v-text-field>
                    <v-text-field :error="item.error" :rules="[rules.required]"  type="number" v-model="item.quantity" label="数量"></v-text-field>
                    <v-btn class="mt-3" text icon small color="error" @click="deleteItem(index)">
                        <v-icon>cancel</v-icon>
                    </v-btn>
                </div>
            </v-col>
            <v-col cols="12" md="2">
                <v-btn color="deep-purple darken-3" dark class="mt-3" width="100" @click="addItem">行追加</v-btn>
                <v-btn color="green darken-2" dark class="mt-3" width="100" @click="save">SAVE</v-btn>
            </v-col>
        </v-row>
        <v-divider></v-divider>
    </v-form>
</script>
<?php ob_start(); ?>
<script>
    const box_item = Vue.component('box-item', {
        props: ['id', 'box'],
        template: '#box_item',
        data() {
            return {
                box_name: '',
                weight: '',
                items: [],
                deleted_items: [],
                rules: {
                    required: value => !!value || 'Required',
                    sku: value => (value !=='' && value!=='Not Found') || 'Required'
                },
            }
        },
        created() {
            if(this.id!=0){
                this.box_name = this.box.box_name;
                this.weight = this.box.weight;
                this.getBoxs();
            }else{
                this.addItem();
            }
        },
        methods: {
            getBoxs() {
                http.get(`store/get_box_items/${this.id}`).then(res => {
                    this.items = res.data;
                });
            },
            addItem() {
                this.items.push({
                    id: 0,
                    fnsku: '',
                    sku: '',
                    quantity: null,
                    error: false
                });
            },
            deleteItem(index) {
                // if(index!=0){
                    this.deleted_items.push(this.items[index].id)
                    this.$delete(this.items, index);
                // }
            },
            getSku(index) {
                if(this.items[index].fnsku!=''){
                    http.get(`store/get_sku/${this.items[index].fnsku}`).then(res => {
                        if(res.data==''){
                            this.items[index].sku = 'Not Found';
                            this.items[index].error = true;
                            
                        }else{
                            this.items[index].sku = res.data;
                            this.items[index].error = false;
                        }
                    });
                }else{
                    this.items[index].sku = '';
                    this.items[index].error = false;
                }
            },
            save () {
                if (this.$refs.form.validate()) {
                    http.post(`store/save_box/${this.id}`, {
                        shipment_id: this.$route.params.shipment_id,
                        box_name: this.box_name,
                        weight: this.weight,
                        items: this.items,
                        deleted_items: this.deleted_items
                    }).then(res => {
                        if(this.$route.params.from=='make'){
                            this.$router.go();
                        }else{
                            if(this.id==0){
                                this.id = res.data['box_id'];
                                this.items = res.data['items'];
                            }
                        }
                    });
                }
            },
        },
        computed: {
            total_quantity(){
                return this.items.map(item=>item.quantity).reduce((a, b)=>{return Number(a) + Number(b)}, 0);
            }
        },
    });
</script>
<?php
    $page_script = ob_get_clean();
    append_js($page_script);
?>
<!-- End Box Item Component -->

<!-- Box Create Component -->
<script type="text/x-template" id="box_create">
    <v-content>
        <shipment-header></shipment-header>
        <box-item v-bind:id="0"></box-item>
    </v-content>
</script>
<?php ob_start(); ?>
<script>
    const box_create = Vue.component('box-create', {
        template: '#box_create',
        data() {
            return {
            }
        },
    });
</script>
<?php
    $page_script = ob_get_clean();
    append_js($page_script);
?>
<!-- End Box Create Component -->

<!-- Box Update Component -->
<script type="text/x-template" id="box_update">
    <v-content>
        <v-overlay :value="loading" :opacity="0.1">
            <v-progress-circular :size="50" :width="5" indeterminate color="deep-purple accent-4"></v-progress-circular>
        </v-overlay>

        <shipment-header></shipment-header>
        <box-item v-for="box in boxs" :key="box.id" v-bind:id="box.id" v-bind:box="box"></box-item>
    </v-content>
</script>
<?php ob_start(); ?>
<script>
    const box_update = Vue.component('box-update', {
        template: '#box_update',
        data() {
            return {
                loading: false,
                boxs: []
            }
        },
        created() {
            this.getBoxs();
        },
        mounted() {
            page_content_onresize();
        },
        methods: {
            getBoxs() {
                this.loading = true;
                const shipment_id = this.$route.params.shipment_id;
                http.get(`store/get_boxs/${shipment_id}`).then(res => {
                    this.boxs = res.data;
                    this.loading = false;
                });
            },
        }
    });
</script>
<?php
    $page_script = ob_get_clean();
    append_js($page_script);
?>
<!-- End Box Update Component -->

<!-- Main Page -->
<style>
    .v-application--wrap {
        min-height: 0%;
    }
    label{
        font-weight: 400;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info">出庫</h3>
    </div>
    <div class="panel-body">
        <div id="app">
            <v-app>
                <router-view></router-view>
            </v-app>
        </div>
    </div>
</div>

<?php ob_start(); ?>
<script>
    const routes = [
        { path: '/', component: shipments_list },
        { path: '/box/create/:shipment_id/:from', component: box_create },
        { path: '/box/update/:shipment_id', component: box_update }
    ];

    const router = new VueRouter({
        routes
    });

    Vue.use(Vuetify);
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        router
    });
</script>
<?php
    $page_script = ob_get_clean();
    append_js($page_script);
?>
<!-- End Main Page -->