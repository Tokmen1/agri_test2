<template>
  <div class="wrapper">
    <div class="animated fadeIn">
      <b-card>
        <b-row>
          <b-col>
            <h4>{{ `${this.typeText} dati` }}</h4>
          </b-col>
          <b-col md="auto">
            <b-button-group>
                <b-button v-if="!contentIsLoading" class="mb-3" variant="primary" 
                :to="{ name: 'FieldAddOnsCreate', params:{ field_id: this.fieldId, type: this.filters.type } }"
                >
                  {{ `Pievienot jaunus ${this.typeText} datus` }}
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
                <div v-else v-b-popover.hover.bottom="`Spied pogu \'\'Pievienot jaunus ${this.typeText} datus\'\'`">
                  {{ `Tabulā nav ievadīti ${this.typeText} dati!` }}
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
                <template v-slot:cell(amount_per_ha)="row">
                  {{ row.item.amount_per_ha + " " + row.item.unit_of_measure}}
                </template>
                <template v-slot:cell(options)="row">
                  <div class="flex-container options-center">
                  <router-link :to="{ name: 'FieldAddOnsUpdate', params:{ id: row.item.id }}">
                    <a><i class="mx-1 fa fa-edit fa-lg"/></a>
                    <b-btn variant="primary" class="mx-1">Rediģēt</b-btn>
                  </router-link>
                  <b-btn href="#" @click="delete_data(row.item.id)" variant="danger" class="mx-1">Dzēst</b-btn>
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
import AlertMixin from '@/mixins/AlertMixin';

export default {
  mounted() {
    this.getData();
  },
  props: ['page', 'id', 'field_id', 'type'],
  data() {
    return {
      list: {
        data: {},
      },
      tableFields: [
        { key: 'name', sortable: true, label: 'Nosaukums' },
        { key: 'amount_per_ha', sortable: true, label: 'Daudzums uz ha' },
        { key: 'cost', sortable: true, label: 'Izmaksas EUR' },
        { key: 'date_from', sortable: true, label: 'Sākuma datums' },
        { key: 'date_to', sortable: true, label: 'Noslēguma datums' },
        { key: 'options', label: 'Iespējas' },
      ],
      filters: {
        sort_field: 'updated_at',
        sort_order: true,
        search: '',
        field_id: this.$route.params.field_id,
        type: this.$route.params.type,
      }
    };
  },
  components: {
    Pagination
  },
  computed: {
    typeText() {
      if (this.filters.type == 'lime') {
        return 'Kaļķa';
      } else if (this.filters.type == "AAL") {
        return "AAL";
      } else {
        return "Minerālmēslu";
      }
    },
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
    delete_data($my_id) {
      if (confirm('Vai tiešām vēlaties izdzēst?')){
        Services.fieldAddOns.delete($my_id).then(() => {
          this.getData();
          this.alertSuccess({text: 'Atlasītais ierakst ir veiksmīgi dzēsts!', title: 'Veiksmīgi dzēsts'});
        }).catch(err => console.log(err));
      }
    },
    getData() {
      Services.fieldAddOns.list(this.params).then((data) => {
        this.list.data = data.data;
      });
    },
    onPageChange(page) {
      page = page || this.page;
      if (page !== this.page) this.$router.push({ name: 'FieldAddOns', params: { page } });
    },
  },
  mixins: [AlertMixin]
};
</script>
