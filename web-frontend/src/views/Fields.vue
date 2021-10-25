<template>
  <div class="wrapper">
    <div class="animated fadeIn">
      <b-card>
        <b-row>
          <b-col>
            <h4>{{ 'nav.fields_list_title' }}</h4>
          </b-col>
          <b-col md="auto">
            <b-button-group>
              <!-- <router-link to="FieldCreate"> -->
                <b-button v-if="!contentIsLoading" class="mb-3" variant="primary" :to="{ name: 'FieldCreate' }">
                  {{ 'field.create_new' }}
                </b-button>
              <!-- </router-link> -->
            </b-button-group>
          </b-col>
        </b-row>
        <b-row v-if="tableItems.length">
          <b-col>
            <b-form-group>
              <b-input-group>
                <b-form-input :v-model="filters.search" @change="getData()"></b-form-input>
                <h1>{{filters.search}}</h1>
                <b-input-group-append>
                  <b-button variant="primary" @click="getData()"><i class="fa fa-search"/></b-button>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col md="auto">
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
              <div  v-if="!tableItems.length"> datu nav</div>
              <!-- <NoDataView v-if="!tableItems.length"/> -->
              <b-table v-else class="table-sm text-center" responsive bordered
                  :no-local-sorting=true
                  :sort-by.sync="filters.sort_field"
                  :sort-desc.sync="filters.sort_order"
                  :fields="tableFields"
                  :items="tableItems"

                  >
                <template v-slot:cell(options)="row">
                  <div class="flex-container options-center">
                  <router-link :to="{ name: 'FieldUpdate', params:{ id: row.item.id }}">
                    <a><i class="mx-1 fa fa-edit fa-lg"/></a>
                    <b-btn>Update</b-btn>
                  </router-link>
                  <b-btn href="#" @click="delete_data(row.item.id)">Delete</b-btn>
                  <!-- <Delete v-if="row.item.actions.delete"  :id="row.item.id" @deleted="getData" :deleteFn="()=>deleteFn(row.item.id)" /> -->
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
// import statuses from '@/store/statuses';
// import { mapState, mapActions } from 'vuex';
import Pagination from 'laravel-vue-pagination';
// import VT from '@/store/types';
// import NoDataView from '@/viewDeletes/Shared/NoDataView.vue';
// import Delete from '@/views/Shared/ModalDelete';
// var Services = require("services");
// import Services from 'services';
import Services from '@/services/index';


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
        { key: 'id', sortable: true, label: 'global.id' },
        { key: 'field_name', sortable: true, label: 'field.name' },
        { key: 'area', sortable: true, label: 'area (ha)'},
        { key: 'created_at', sortable: true, label: 'global.created_at' },
        { key: 'updated_at', sortable: true, label: 'global.updated_at' },
        { key: 'options', label: 'global.options' },
        { kegetData_field: null, sort_order: null, search: '' },
      ],
      filters: {
        sort_field: null,
        sort_order: null,
        search: '00',
      }
    };
  },
  components: {
    Pagination// NoDataView, Delete
  },
  computed: {
    // ...mapState('Fields', {
    //   list: 'fieldsList'
    // }),
    listPaginator() {
      return Object.is(this.list.data, undefined) ? {} : this.list.data.meta;
    },
    tableItems() {
      return this.list.data.data || [];
    },
    contentIsLoading() {
      return false;
      // return this.list.status !== statuses.LOADED;
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
    delete_data($my_id){
      Services.fields.delete($my_id);
      window.alert("Iteam with id: "+$my_id+ " deleted!")
      this.getData();
    },
    // ...mapActions('Fields', {
    //   listData: VT.FIELDS_LIST,
    //   deleteFn: VT.FIELD_DELETE,
    // }),
    getData() {
      // this.listData(this.params);
      this.list.data = {};
      Services.fields.list({ page: 1 }).then((data) => {
        this.list.data = data.data;
        console.log("search: ",this.filters.search);
      });

      // fields.list({ page: 1 }).then((data) => {
      //   this.list.data = data;
      // });
    },
    onPageChange(page) {
      page = page || this.page;
      if (page !== this.page) this.$router.push({ name: 'Fields', params: { page } });
    },
  }
};
</script>

<style scoped>
</style>
