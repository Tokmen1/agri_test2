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
                  {{ 'Create new field' }}
                </b-button>
              <!-- </router-link> -->
            </b-button-group>
          </b-col>
        </b-row>
        <b-row v-if="tableItems.length">
          <b-col>
            <b-form-group>
              <b-input-group>
                <b-form-input v-model="filters.search"></b-form-input>
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
                    <b-btn>Update</b-btn>
                  </router-link>
                  <b-btn v-if="row.item.actions.delete" @click="delete_data(row.item.id)">Delete</b-btn>
                  <router-link :to="{ name: 'FieldActions', params:{ id: row.item.id, page: 1 }}">
                    <b-btn>Add action</b-btn>
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
        { key: 'id', sortable: true, label: 'ID' },
        { key: 'field_name', sortable: true, label: 'Field.name' },
        { key: 'area', sortable: true, label: 'Area (ha)'},
        { key: 'created_at', sortable: true, label: 'Created_at' },
        { key: 'updated_at', sortable: true, label: 'Updated_at' },
        { key: 'options', label: 'Options' },
      ],
      filters: {
        sort_field: null,
        sort_order: null,
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
      Services.fields.delete($my_id);
      window.alert("Iteam with id: "+$my_id+ " deleted!");
      this.getData();
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
  }
};
</script>

<style scoped>
</style>
