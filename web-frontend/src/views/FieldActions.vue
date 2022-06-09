<template>
  <div class="wrapper">
    <div class="animated fadeIn">
      <b-card>
        <b-row>
          <b-col>
            <h4>{{ 'Darbības laukā' }}</h4>
          </b-col>
          <b-col md="auto">
            <b-button-group>
                <b-button v-if="!contentIsLoading" class="mb-3" variant="primary" :to="{ name: 'FieldActionsCreate', params:{ field_id: this.filters.thisSpecificField } }">
                  {{ 'Pievienot jaunu darbību' }}
                </b-button>
            </b-button-group>
          </b-col>
        </b-row>
        <b-row v-if="tableItems.length">
          <b-col>
            <b-form-group>
              <b-input-group>
                <b-form-input v-model="filters.search" placeholder="Meklēt..." debounce="700"></b-form-input>
                <b-input-group-append>
                  <b-button variant="primary" @click="getData()"><b-icon icon="search" /></b-button>
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
                  <router-link :to="{ name: 'FieldActionsUpdate', params:{ id: row.item.id }}">
                    <a><i class="mx-1 fa fa-edit fa-lg"/></a>
                    <b-btn variant="primary" class="mx-1">Rediģēt</b-btn>
                  </router-link>
                  <b-btn href="#" @click="delete_data(row.item.id)" variant="danger" class="mx-1">Dzēst</b-btn>
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
import Pagination from 'laravel-vue-pagination';
import Services from '@/services/index';

export default {
  mounted() {
    this.getData();
  },
  props: ['page', 'id'],
  data() {
    return {
      list: {
        data: {},
      },
      tableFields: [
        // { key: 'id', sortable: true, label: 'ID' },
        { key: 'action_type', sortable: true, label: 'Darbības tips' },
        { key: 'date_from', sortable: true, label: 'Darbības sākuma datums' },
        { key: 'date_to', sortable: true, label: 'Darbības beigu datums' },
        { key: 'options', label: 'Iespējas' },
      ],
      filters: {
        sort_field: null,
        sort_order: null,
        search: '',
        thisSpecificField: this.$route.params.id,
      }
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
      Services.fieldactions.delete($my_id);
      window.alert('Iteam with id: ', $my_id, ' deleted');
      this.getData();
    },
    getData() {
      Services.fieldactions.list(this.params).then((data) => {
        this.list.data = data.data;
      });
    },
    onPageChange(page) {
      page = page || this.page;
      if (page !== this.page) this.$router.push({ name: 'FieldActions', params: { page } });
    },
  }
};
</script>

<style scoped>
</style>
