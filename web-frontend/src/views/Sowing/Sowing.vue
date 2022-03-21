<template>
  <div class="wrapper">
    <div class="animated fadeIn">
      <b-card>
        <b-row>
          <b-col>
            <h4>Sējas dati</h4>
          </b-col>
          <b-col md="auto">
            <b-button-group>
                <b-button v-if="!contentIsLoading" class="mb-3" variant="primary" 
                :to="{ name: 'SowingCreate', params:{ field_id: this.fieldId } }"
                >
                  Pievienot jaunus sējas datus
                </b-button>
            </b-button-group>
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
                <div v-else v-b-popover.hover.bottom="'Spied pogu \'\'Pievienot jaunus sējas datus\'\''">
                  Tabulā nav ievadīti dati!
                </div>
              </div>
              <!-- <NoDataView v-if="!tableItems.length"/> -->
              <b-table v-else class="table-sm text-center" responsive bordered
                  :no-local-sorting=true
                  :sort-by.sync="filters.sort_field"
                  :sort-desc.sync="filters.sort_order"
                  :fields="tableFields"
                  :items="tableItems"
                  >
                <!-- <template v-slot:cell(pre_plant)="row">
                  <div class="flex-container">
                    {{ getPrePlant(row.item.id-2) }}
                  </div>
                </template> -->
                <template v-slot:cell(options)="row">
                  <div class="flex-container options-center">
                  <router-link :to="{ name: 'SowingUpdate', params:{ id: row.item.id }}">
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
  props: ['page', 'id', 'field_id'],
  data() {
    return {
      list: {
        data: {},
      },
      tableFields: [
        { key: 'name', sortable: true, label: 'Kultūraugs' },
        { key: 'breed', sortable: true, label: 'Šķirne' },
        { key: 'pre_plant', sortable: true, label: 'Priekšaugs' },
        { key: 'sowing_rate', sortable: true, label: 'Izsējas norma (kg/ha)' },
        { key: 'date_from', sortable: true, label: 'Sākuma datums' },
        { key: 'date_to', sortable: true, label: 'Noslēguma datums' },
        { key: 'options', label: 'Iespējas' },
      ],
      filters: {
        sort_field: 'updated_at',
        sort_order: true,
        search: '',
        field_id: this.$route.params.field_id,
        
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
    getPrePlant(prePlantId) {
      try {
        return this.tableItems[prePlantId].name + ' ' + this.tableItems[prePlantId].breed
      } catch {
        return 'NAV'
      }
    },
    delete_data($my_id) {
      Services.sowing.delete($my_id);
      window.alert('Iteam with id: ', $my_id, ' deleted');
      this.getData();
    },
    getData() {
      Services.sowing.list(this.params).then((data) => {
        this.list.data = data.data;
      });
    },
    onPageChange(page) {
      page = page || this.page;
      if (page !== this.page) this.$router.push({ name: 'Sowing', params: { page } });
    },
  }
};
</script>
