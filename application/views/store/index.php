<?php
    // vuejs include
    append_js_file('https://cdn.jsdelivr.net/npm/vue@2.6.11');
    // append_js_file('https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.js');
    append_js_file('https://cdn.jsdelivr.net/npm/vuetify@2.2.14');
    // append_js_file('https://cdn.jsdelivr.net/npm/vuetify@2.2.14/dist/vuetify.js');
    append_css_file('https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900');
    append_css_file('https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp');
    append_css_file('https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css');
    append_css_file('https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css');

    //jspdf include
    append_js_file('https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js');
    append_js_file('https://unpkg.com/jspdf@1.5.3/dist/jspdf.min.js');
    append_js_file('https://unpkg.com/jspdf-autotable@3.5.4/dist/jspdf.plugin.autotable.min.js');
    append_js_file('https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js');

    append_js_file("{$assets_url}lib/KosugiMaru-Regular-normal.js");

?>
<style>
    .v-application--wrap {
        min-height: 0%;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="text-info">入庫</h3>
    </div>
    <div class="panel-body">
        <div id="app">
            <v-app>
                <v-content>
                    <v-overlay :value="loading" :opacity="0">
                        <v-progress-circular :size="50" :width="5" indeterminate color="deep-purple accent-4"></v-progress-circular>
                    </v-overlay>

                    <v-text-field v-model="jan" label="JAN Code" @change='getProduct' style="width:300px;"></v-text-field>
                    <v-data-table v-model="selected" :headers="headers" :items="products" height='150' :fixed-header="true" item-key="id" :hide-default-footer="true" :disable-pagination='true' show-select class="elevation-1"></v-data-table>
                    <div class="layout input mt-4">
                        <v-text-field v-model="prefix" label="Prefix"></v-text-field>
                        <v-text-field v-model="number" label="Number" class="mx-2" type="number" :min="1"></v-text-field>
                        <v-text-field v-model="seller" label="Seller"></v-text-field>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="items" label="Items" class="mx-2" type="number" :min="1"></v-text-field>
                        <v-btn color="primary" class="ma-3" width="90" @click="addItem">Add</v-btn>
                        <v-btn color="error" class="mt-3" width="90" @click="clearItem">Clear</v-btn>
                    </div>

                    <v-simple-table height="300" :fixed-header="true" class="elevation-2">
                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <th class="text-left">Group Name</th>
                                    <th class="text-left">SKU</th>
                                    <th class="text-left">FNSKU</th>
                                    <th class="text-left">JAN</th>
                                    <th class="text-left">Items</th>
                                    <th class="text-left" style="width: 120px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in imported_products" :key="item.id">
                                    <td>{{ item.group }}</td>
                                    <td>{{ item.sku }}</td>
                                    <td>{{ item.fnsku }}</td>
                                    <td>{{ item.jan }}</td>
                                    <td>{{ item.items }}</td>
                                    <td>
                                        <v-btn text icon small color="error" @click="deleteItem(index)">
                                            <v-icon>cancel</v-icon>
                                        </v-btn>
                                        <v-btn text icon small color="primary">
                                            <v-icon>verified_user</v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                    <v-btn color="primary" class="float-right mt-5" @click="generate">
                        <v-icon left dark>verified_user</v-icon>Generate FBA Label
                    </v-btn>

                    <v-dialog v-model="dialog" persistent max-width="400">
                        <v-card>
                            <v-card-title class="headline">Completed to generate</v-card-title>
                            <v-card-text>PDF sheet has been successfully generated.</v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="green darken-1" text @click="dialog = false">Cancel</v-btn>
                                <v-btn color="green darken-1" text @click="download">Download</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <img id="barcode" style="display: none">
                </v-content>
            </v-app>
        </div>
    </div>
</div>
<?php
ob_start();
?>
<script>
    var uniqID = function() {
        return '_' + Math.random().toString(36).substr(2, 9);
    };

    Vue.use(Vuetify);

    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data() {
            return {
                jan: null,
                prefix: '<?= date('Ymd'); ?>',
                number: 1,
                seller: '<?= $this->seller_id; ?>',
                items: 1,
                loading: false,
                dialog: false,
                pdf: null,
                products: [],
                selected: [],
                imported_products: [],
                headers: [{
                        text: 'SKU',
                        align: 'left',
                        sortable: false,
                        value: 'sku',
                    },
                    {
                        text: 'FNSKU',
                        value: 'fnsku'
                    },
                    {
                        text: 'JAN',
                        value: 'jan'
                    },
                    {
                        text: 'ASIN',
                        value: 'asin'
                    }
                ],
            }
        },

        watch: {
            // jan: function (newQuestion, oldQuestion) {
            //     this.getAnswer()
            // }
        },
        methods: {
            getProduct() {
                axios.post('<?= site_url("store/get_product"); ?>', {
                    jan: this.jan
                }).then(res => {
                    this.products = res.data;
                    this.selected = [];
                });
            },
            addItem() {
                var group = this.prefix + '-' + this.number + '-' + this.seller;
                this.selected.map(product => {
                    this.imported_products.push({
                        id: uniqID(),
                        group: group,
                        sku: product.sku,
                        fnsku: product.fnsku,
                        jan: product.jan,
                        name: product.name,
                        name_en: product.name_en,
                        items: this.items
                    });
                    this.jan = '';
                    this.products = [];
                    this.selected = [];
                });
            },
            deleteItem(index) {
                this.$delete(this.imported_products, index);
            },
            clearItem() {
                this.imported_products = [];
            },
            generate() {
                if(this.imported_products.length==0){
                    return;
                }
                this.loading = true;
                // axios({
                //     url: '<?= site_url("store/generate"); ?>',
                //     method: 'POST',
                //     responseType: 'blob',
                //     data: {
                //         items: this.imported_products
                //     }
                // }).then((response) => {
                    let groups = this.imported_products.map(item => item.group).filter((value, index, self) => self.indexOf(value) === index)

                    this.pdf = new jsPDF('p','mm','a4');
                    this.pdf.setFont('KosugiMaru-Regular');
                    //Add Header
                    this.pdf.autoTable({
                        head: [
                            [{ content: groups.toString(), styles: { halign: 'center', fillColor: '#536D79', textColor: '#FFFFFF', fontSize: 17 } }],
                        ],
                        body: [
                            [{ content: 'Generated by FBA-GEN', styles: { halign: 'center', fillColor: '#536D79', textColor: '#AFBDC5', fontSize: 8 } }],
                            [{ content: 'Generated at ' + Date(), styles: { halign: 'left', fillColor: '#FFF', textColor: '#71818A', fontSize: 12, font: 'KosugiMaru-Regular' } }],
                        ],
                    });
                    //Add Items
                    this.pdf.autoTable({
                        columns: [
                            { header: 'SKU', dataKey: 'sku' },
                            { header: 'JAN', dataKey: 'jan' },
                            { header: 'FNSKU', dataKey: 'fnsku' },
                            { header: 'Product Name', dataKey: 'name' },
                            { header: 'Items', dataKey: 'items' },
                        ],
                        columnStyles: { 
                            sku: { halign: 'left', valign:'middle', fillColor: '#FFFFFF', textColor: '#000000', fontSize: 10, lineColor: '#536D79', lineWidth: 0.1, overflow: 'linebreak', cellWidth: 30 },
                            jan:  { halign: 'left', valign:'middle', fillColor: '#FFFFFF', textColor: '#000000', fontSize: 10, lineColor: '#536D79', lineWidth: 0.1, overflow: 'linebreak', cellWidth: 30 },
                            fnsku:  { halign: 'left', valign:'middle', fillColor: '#FFFFFF', textColor: '#000000', fontSize: 10, lineColor: '#536D79', lineWidth: 0.1, overflow: 'linebreak', cellWidth: 30 },
                            name: { halign: 'left', valign:'middle', fillColor: '#FFFFFF', textColor: '#000000', fontSize: 10, lineColor: '#536D79', lineWidth: 0.1, overflow: 'linebreak', cellWidth: 'auto', font: 'KosugiMaru-Regular' },
                            items: { halign: 'left', valign:'middle', fillColor: '#FFFFFF', textColor: '#000000', fontSize: 10, lineColor: '#536D79', lineWidth: 0.1, overflow: 'linebreak', cellWidth: 15 },
                        },
                        headStyles: { halign: 'center', valign:'middle', fillColor: '#CFD7DC', textColor: '#000000', fontSize: 11, fontStyle: 'bold', lineColor: '#536D79', lineWidth: 0.1, overflow: 'linebreak'  },
                        body: this.imported_products,
                    });
                    
                    //Add Barcode
                    this.pdf.setFontSize(7);
                    this.pdf.setLineWidth(3);
                    this.pdf.setDrawColor(0, 0, 201); 
                    const img = document.querySelector('img#barcode');
                    let total_index = 0;
                    this.imported_products.map(item=>{
                        let ellip_name = item.name_en;
                        if(ellip_name.length>56){
                            ellip_name = ellip_name.substr(0, 28) + '...' + ellip_name.substr(-28);
                        }
                        // for(i=0; i<item.items; i++){
                        //     if(total_index==0){
                        //         this.pdf.addPage();
                        //     }
                        //     JsBarcode("#barcode", item.fnsku, {
                        //         fontSize: 20
                        //     });
                        //     let x = 0, y = 0;
                        //     const column = Math.floor(total_index/8);
                        //     if(column == 0){
                        //         x = 18;
                        //     } else if(column == 1){
                        //         x = 81;
                        //     } else if(column == 2){
                        //         x = 143.5
                        //     }
                        //     y = 21.5 + (total_index % 8) * 32.3;
                        //     if(i==0){
                        //         this.pdf.line(x - 6, y - 3, x + 52, y - 3)
                        //     }
                        //     this.pdf.addImage(img.src, 'JPEG', x - 1.45, y, 50, 17);
                        //     this.pdf.text(ellip_name.substr(0, 35), x, y + 18 + 2.3);
                        //     this.pdf.text(ellip_name.substr(35), x, y + 18 + 2.3 + 2.3);
                        //     this.pdf.text('New', x, y + 18 + 2.3 + 2.3 + 2.8);
                        //     if(total_index==23){
                        //         total_index = 0;
                        //     }else{
                        //         total_index++;
                        //     }
                        // }
                        for(i = 0; i < item.items; i++){
                            if(total_index==0){
                                this.pdf.addPage();
                            }
                            JsBarcode("#barcode", item.fnsku, {
                                fontSize: 20
                            });
                            let x = 0, y = 0;
                            const column = Math.floor(total_index/8);
                            if(column == 0){
                                x = 13;
                            } else if(column == 1){
                                x = 81;
                            } else if(column == 2){
                                x = 148.5
                            }
                            y = 9.5 + (total_index % 8) * 36.3;
                            if(i==0){
                                this.pdf.line(x - 6, y - 3, x + 52, y - 3)
                            }
                            this.pdf.addImage(img.src, 'JPEG', x - 1.45, y, 50, 17);
                            this.pdf.text(ellip_name.substr(0, 35), x, y + 18 + 2.3);
                            if(ellip_name.substr(35)==''){
                                this.pdf.text('New', x, y + 18 + 2.3 + 2.3);
                            }else{
                                this.pdf.text(ellip_name.substr(35), x, y + 18 + 2.3 + 2.3);
                                this.pdf.text('New', x, y + 18 + 2.3 + 2.3 + 2.8);
                            }
                            if(total_index==23){
                                total_index = 0;
                            }else{
                                total_index++;
                            }
                        }
                    });
                    this.loading = false;
                    this.dialog = true;
                // }).catch(err => {
                //     this.loading = false;
                //     console.error(err);
                // });
            },
            download() {
                this.pdf.save(this.prefix+'.pdf');
                this.dialog = false;
            }
        },
        mounted() {},
        computed: {
            now: function() {
                return Date.now()
            }
        }
    })
</script>
<?php
$page_script =  ob_get_contents();
ob_end_clean();
append_js($page_script);
?>