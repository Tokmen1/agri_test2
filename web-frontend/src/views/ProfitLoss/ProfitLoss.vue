<template>
  <div class="wrapper">
    <div class="animated fadeIn">
      <b-card>
        <b-row>
          <b-col>
            <h4>Atskaite</h4>
          </b-col>
        </b-row>
        <b-row >
          <b-col>
            <b-form-group>
              <b-input-group>
                <b-form-input v-model="filters.search" placeholder="Meklēt..." debounce="700"></b-form-input>
                <b-input-group-append>
                  <b-button variant="primary" @click="getData()"><b-icon icon="search" /></b-button>
                </b-input-group-append>
              </b-input-group>
              <b-input-group>
                <label id="start_date">Datums no:</label>
                <b-form-input v-model="filters.search_date_from" type="date" placeholder="Meklēt..." debounce="500"></b-form-input>
              </b-input-group>
              <b-input-group>
                <label>Datums līdz:</label>
                <b-form-input v-model="filters.search_date_to" type="date" placeholder="Meklēt..." debounce="500"></b-form-input>
              </b-input-group>
              <b-row class="pt-2">
                <b-col>
                  <b>Kopējie ienākumi: {{ profit_value.toFixed(2) }}</b>
                </b-col>
                <b-col>
                  <b>Kopējie tēriņi: {{ loss_value.toFixed(2) }}</b>
                </b-col>
                <b-col>
                  <b>Ienākumi - tēriņi: {{ loss_value + profit_value }}</b>
                </b-col>
              </b-row>
              <b-btn v-if="!isHidden" variant="primary" @click="printer()" >
                Printēt
              </b-btn>
            </b-form-group>
          </b-col>
          <b-col md="auto" v-if="tableItems.length">
            <!--Paginator at top-->
            <Pagination class="pull-right" :data="listPaginator" :limit="5" @pagination-change-page="onPageChange"/>
          </b-col>
        </b-row>
        <div v-if="contentIsLoading" class="text-center">
          <b-spinner type="grow" variant="primary"/>
        </div>
        <div v-else>
          <b-row>
            <b-col>
              <div v-if="!tableItems.length">
                <div v-if="filters.search">Netika atrasti dati ar vārdu <b>"{{ filters.search }}"</b>!</div> 
                <div v-else>
                  Tabulā nav ievadīti dati!
                </div>
              </div>
              <b-table v-else class="table-sm text-center" responsive bordered
                  :no-local-sorting=true
                  :sort-by.sync="filters.sortField"
                  :sort-desc.sync="filters.sort_order"
                  :fields="tableFields"
                  :items="tableItems"
                  >
              </b-table>
            </b-col>
          </b-row>
          <b-row>
            <!--Paginator at bottom-->
            <b-col v-if="tableItems.length">
              <Pagination :data="listPaginator" :limit="5" @pagination-change-page="onPageChange"/>
            </b-col>
          </b-row>
        </div>
      </b-card>
    </div>
  </div>
</template>

<script>
import Pagination from 'laravel-vue-pagination';
import Services from '@/services/index';
import AlertMixin from '@/mixins/AlertMixin';

export default {
  mounted() {
    this.getData();
  },
  props: ['page', 'id', 'field_id'],
  data() {
    return {
      list: {
        data: {},
      },
      tableFields: [
        { key: 'field_name', sortable: true, label: 'Lauka nosaukums' },
        { key: 'whoIm', sortable: true, label: 'Darbība' },
        { key: 'name', sortable: true, label: 'Nosaukums' },
        { key: 'cost', sortable: true, label: 'Cena EUR' },
        { key: 'date_from', sortable: true, label: 'Sākuma datums' },
        { key: 'date_to', sortable: true, label: 'Noslēguma datums' },
        // { key: 'options', label: 'Iespējas' },
      ],
      filters: {
        sortField: 'date_from',
        sort_order: true,
        search: '',
        field_id: this.$route.params.field_id,
        search_date_from: '',
        search_date_to: '',
      }, 
      isHidden: false,
      profit_value: 1,
      loss_value: 1,
    };
  },
  components: {
    Pagination
  },
  computed: {
    filteredRecords() {
      return this.list.data.filter((record) => {
        return record.match(this.filters.search);
      });
    },
    listPaginator() {
      return Object.is(this.list.data, undefined) ? {} : this.list.data.meta;
    },
    tableItems() {
      return this.list.data || [];
    },
    contentIsLoading() {
      return false;
    },
    fieldId() {
      return this.$route.params.field_id;
    },
    params() {
      return {
        ...this.filters,
        page: this.page,
        sort_order: this.filters.sort_order ? 'desc' : 'asc'
      };
    },
  },
  watch: {
    page: 'getData',
    filters: { deep: true, handler: 'getData' },
  },
  methods: {
    countProfit(whoIm, cost){
      if(whoIm == "Raža"){
        this.profit_value = this.profit_value + cost;
        // this.profit_value.toFixed(2);
      } else {
        this.loss_value = this.loss_value - cost;
        // this.loss_value.toFixed(2);
      }
    },
    printer(){
      this.isHidden = true;
      setTimeout(function(){ window.print(); }, 100)
      setTimeout(function(){this.isHidden = false; }, 5000);
    },
    getData() {
      Services.report.list(this.params).then((data) => {
        this.profit_value = 0;
        this.loss_value = 0;
        data.data.forEach(el => {
          this.countProfit(el.whoIm, el.cost);
        });
        this.list.data = data.data;
      });
    },
    onPageChange(page) {
      page = page || this.page;
      if (page !== this.page) this.$router.push({ name: 'ProfitLoss', params: { page } });
    },
  },
  mixins: [AlertMixin]
};
</script>
<style scoped>
#start_date{
  margin-right: 7px;
}
</style>
