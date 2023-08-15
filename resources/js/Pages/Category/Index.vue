<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
// import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import DataTable from 'datatables.net-vue3';
// import DataTablesLib from "datatables.net";
import { VDataTable } from 'vuetify/labs/components';
import { VDialog, VOverlay } from 'vuetify/lib/components/index.mjs';
import axios from 'axios';


// DataTable.use(DataTablesLib);

const categories = ref([]);
const headers = ref([
  { title: 'Name', key: 'name' },
  { title: 'Description', key: 'description' },
  { title: 'Company Name', key: 'company.name' },
  { title: 'Created Day', key: 'created_at' },
  { title: '', key: 'update' },
  { title: '', key: 'delete' },
]);
const itemsPerPage = ref(5);
const dialog = ref(false);
const loading = ref(false);
const absolute = ref(true);
const overlayDialog = ref(false);
const formType = ref('new');
const form = useForm({
  name: '',
  description: '',
  company_id: '',
});
const typeSelects = ref([]);
const categorySelected = ref({});
const rules = ref({
  required: value => !!value || 'Required.',
  email: value => {
    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return pattern.test(value) || 'Invalid e-mail.'
  },
});

onMounted(async () => {
  //   getAllCompanies();
  const res = await axios.get('/api/categories/all');
  categories.value = res.data;
});

async function getAllCategories() {
  const res = await axios.get('/api/categories/all');
  categories.value = res.data;
}

const createNew = async () => {
  dialog.value = true;
  formType.value = "new";
  form.name = null;
  form.description = null;
  form.company_id = null;
};

const edit = async (item) => {
  formType.value = 'edit';
  const categoryDetails = await axios.get(`/api/categories/show/${item.id}`);
  categorySelected.value = categoryDetails.data;
  form.name = categoryDetails.data.name;
  form.description = categoryDetails.data.description;
  form.company_id = categoryDetails.data.company_id;
  dialog.value = true;
};

const save = async () => {
  if (formType.value == 'new') {
    storeCategory();
  } else {
    updateCategory()
  }
}

const storeCategory = async () => {
  const saveCategory = await axios.post("/api/categories/store", {
    'name': form.name,
    'description': form.description,
    'company_id': form.company_id
  });

  if (!saveCategory) {
    // ref.error.snackbar = true;
    // ref.error.text = "Error。";
    overlayDialog.value = false;
    loading.value = false;
  };

  getAllCategories();
  dialog.value = false;
};

const updateCategory = async () => {
  overlayDialog.value = true;
  loading.value = true;
  const categoryUpdate = await axios.post(`/api/categories/update/${categorySelected.value.id}`, {
    'name': form.name,
    'description': form.description,
    'company_id': form.company_id
  });

  if (!categoryUpdate) {
    // ref.error.snackbar = true;
    // error.text = "Error。";
    dialog.value = true;
  }
  // ref.success.snackbar = true;
  getAllCategories();
  overlayDialog.value = false;
  loading.value = false;
  dialog.value = false;
};
</script>

<template>
  <Head title="Category" />

  <AuthenticatedLayout>
    <section>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="mb-2">
              <v-btn depressed color="info" @click="createNew()">Create new</v-btn>
            </div>
            <v-data-table v-model:items-per-page="itemsPerPage" :headers="headers" :items="categories"
              class="elevation-1">
              <template v-slot:[`item.update`]="{ item }">
                <v-btn depressed color="warning" @click="edit(item.selectable)">Edit</v-btn>
              </template>
              <template v-slot:[`item.delete`]="{ item }">
                <v-btn depressed color="error" @click="destroy(item)" :disabled="item.selectable.type == 1">Delete {{
                  item.id
                }}</v-btn>
              </template>
            </v-data-table>
            <v-overlay v-model="overlayDialog" contained></v-overlay>

            <VDialog v-model="dialog">
              <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                  <v-card>
                    <v-card-title>Register/Update Category</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                      <v-form>
                        <v-row>
                          <v-col cols="12">
                            <label class="text-black font-weight-bold">Name
                              <span class="text-red font-weight-bold">※
                              </span>
                            </label>
                            <v-text-field variant="outlined" color="primary" v-model="form.name"
                              :rules="[rules.required]">
                            </v-text-field>
                          </v-col>
                          <v-col cols="12">
                            <label class="text-black font-weight-bold">Company
                              <span class="text-red font-weight-bold">※
                              </span>
                            </label>
                            <v-select variant="outlined" color="primary" :items="typeSelects" v-model="form.company_id"
                              label="select one">
                            </v-select>
                          </v-col>
                          <v-col cols="12">
                            <label class="text-black font-weight-bold">Description
                              <span class="text-red font-weight-bold">※
                              </span>
                            </label>
                            <v-text-field variant="outlined" color="primary" v-model="form.description"
                              :rules="[rules.required]">
                            </v-text-field>
                          </v-col>
                        </v-row>
                      </v-form>

                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions class="justify-center pa-4">
                      <v-row>
                        <v-col cols="6">
                          <v-btn :loading="loading" depressed block color="warning" @click="save">Save</v-btn>
                        </v-col>
                        <v-col cols="6">
                          <v-btn depressed block color="success" @click="dialog = false">Cancel</v-btn>
                        </v-col>
                      </v-row>
                    </v-card-actions>
                  </v-card>
                </div>
              </div>
            </VDialog>
          </div>
        </div>
      </div>
    </section>
  </AuthenticatedLayout>
</template>

<style>
.v-field__input input:focus {
  border: none;
  box-shadow: unset;
}

.v-input__control {
  max-height: 56px !important;
}

.v-field__input {
  padding-top: unset;
  padding-bottom: unset;
  max-height: 56px !important;
}

.v-field__input input {
  max-height: 56px !important;
  padding: 8px 0 !important;
}

div.v-field__input {
  max-height: 56px !important;
}

.v-alert {
  position: fixed;
  right: 0px;
  top: 0px;
  margin: 0 auto;
}
</style>
