<template>
  <div class="wrapper">
    <div class="animated fadeIn">
      <b-card>
        <b-row>
          <b-col>
            <h4>Lauku dati</h4>
          </b-col>
          <b-col md="auto">
            <b-button-group>
              <!-- <router-link to="FieldCreate"> -->
                <b-button v-if="!contentIsLoading" class="mb-3" variant="primary" :to="{ name: 'FieldCreate' }">
                  Izveidot jaunu lauku
                </b-button>
              <!-- </router-link> -->
            </b-button-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col>
            <b-form-group>
              <b-input-group>
                <b-form-input v-model="filters.search" placeholder="Meklēt..."></b-form-input>
                <b-input-group-append>
                  <b-button variant="primary" @click="getData()"><b-icon icon="search" /></b-button>
                </b-input-group-append>
              </b-input-group>
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
              <div  v-if="!tableItems.length">
                <div v-if="filters.search">Netika atrasti dati ar vārdu <b>"{{ filters.search }}"</b>!</div> 
                <div v-else v-b-popover.hover.bottom="'Spied pogu \'\'Izveidot jaunu lauku\'\''">
                  Tabulā nav ievadīti dati!
                </div>
              </div>
              <b-table v-else class="table-sm text-center" responsive bordered
                  :no-local-sorting=true
                  :sort-by.sync="filters.sort_field"
                  :sort-desc.sync="filters.sort_order"
                  :fields="tableFields"
                  :items="tableItems"
                  >
                <template v-slot:cell(options)="row">
                  <div class="flex-container options-center">
                    <router-link v-if="row.item.actions.update" :to="{ name: 'FieldUpdate', params:{ id: row.item.id }}">
                      <a><i class="mx-1 fa fa-edit fa-lg"/></a>
                      <b-button variant="primary" class="mx-1">Reģidēt</b-button>
                    </router-link>
                    <b-button v-if="row.item.actions.delete" @click="delete_data(row.item.id)" variant="danger" class="mx-1">Dzēst</b-button>
                    <router-link :to="{ name: 'FieldActions', params:{ id: row.item.id, page: 1 }}">
                      <b-button variant="primary" class="mx-1">Pievienot darbību</b-button>
                    </router-link>
                    <router-link :to="{ name: 'Sowing', params:{ field_id: row.item.id, page: 1 }}">
                      <b-button variant="primary" class="mx-1">Sēja dati</b-button>
                    </router-link>
                    <router-link :to="{ name: 'Harvest', params:{ field_id: row.item.id, page: 1 }}">
                      <b-button variant="primary" class="mx-1">Raža dati</b-button>
                    </router-link>
                    <router-link :to="{ name: 'FieldAddOns', params:{ field_id: row.item.id, page: 1, type: 'lime' }}">
                      <b-button variant="primary" class="mx-1">Kaļķa dati</b-button>
                    </router-link>
                    <router-link :to="{ name: 'FieldAddOns', params:{ field_id: row.item.id, page: 1, type: 'AAL' }}">
                      <b-button variant="primary" class="mx-1">AAL dati</b-button>
                    </router-link>
                    <router-link :to="{ name: 'FieldAddOns', params:{ field_id: row.item.id, page: 1, type: 'mineral_fertilizer' }}">
                      <b-button variant="primary" class="mx-1">Minerālmēslojuma dati</b-button>
                    </router-link>
                  </div>
                </template>
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
import { backend } from '@/_axios';
import AlertMixin from '@/mixins/AlertMixin';

export default {
  mounted() {
    this.getData();
  },
  props: ['page'],
  data() {
    return {
      list: {
        data: {},
      },
      tableFields: [
        // { key: 'id', sortable: true, label: 'ID' },
        { key: 'field_name', sortable: true, label: 'Lauka nosaukums' },
        { key: 'area', sortable: true, label: 'Platība (ha)'},
        { key: 'options', label: 'Iespējas' },
      ],
      filters: {
        sort_field: 'updated_at',
        sort_order: true,
        search: '',
      },
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
      return this.list.data.data || [];
    },
    contentIsLoading() {
      return false;
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
    delete_data($my_id) {
      if (confirm('Vai tiešām vēlaties izdzēst?')){
        Services.fields.delete($my_id).then(() => {
          this.getData();
          this.alertSuccess({text: 'Atlasītais ierakst ir veiksmīgi dzēsts!', title: 'Veiksmīgi dzēsts'});
        }).catch(err => console.log(err));
      }
    },
    getData() {
      backend.defaults.headers.common['Authorization'] = 'Bearer ' + sessionStorage.getItem('access_token');
      Services.fields.list(this.params).then((data) => {
        this.list.data = data.data;
        console.log(this.list.data.data[0].actions.view);
      });
    },
    onPageChange(page) {
      page = page || this.page;
      if (page !== this.page) this.$router.push({ name: 'Fields', params: { page } });
    },
  },
  mixins: [AlertMixin]
};
</script>

<style scoped>
</style>
