<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
// import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// import DataTable from 'datatables.net-vue3';
// import DataTablesLib from "datatables.net";
import { VDataTable } from 'vuetify/labs/components';
import { VDialog } from 'vuetify/lib/components/index.mjs';


// DataTable.use(DataTablesLib);

const companies = ref([]);
const headers = ref([
  { title: 'Name', key: 'name' },
  { title: 'Description', key: 'description' },
  { title: 'Type', key: 'type' },
  { title: 'Address', key: 'address' },
  { title: 'Phone Number', key: 'phone_number' },
  { title: 'Created Day', key: 'created_at' },
  { title: '', key: 'update' },
  { title: '', key: 'delete' },
]);
const itemsPerPage = ref(5);
const dialog = ref(false);
const formType = ref('new');
const form = useForm({
  name: '',
  description: '',
  type: '',
  address: '',
  phone_number: '',
});
const typeSelects = ref([1, 2, 3, 4]);
const rules = ref({
  required: value => !!value || 'Required.',
  email: value => {
    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return pattern.test(value) || 'Invalid e-mail.'
  },
});

onMounted(async () => {
  //   getAllCompanies();
  const res = await axios.get('/api/companies/all');
  companies.value = res.data;
  console.log(111, companies.value)
});

// async function getAllCompanies() {
//   const res = await axios.get('/api/companies/all');
//   companies.value = res.data;
//   console.log(111, companies.value)
//   return res.data;
// }

const edit = (item) => {
  dialog.value = true;
};
</script>

<template>
  <Head title="Company" />

  <AuthenticatedLayout>
    <section>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <v-data-table v-model:items-per-page="itemsPerPage" :headers="headers" :items="companies" class="elevation-1">
              <template v-slot:top>
                <div class="my-4">
                  <!-- <v-btn depressed color="info" @click="create()">新規作成</v-btn> -->
                </div>
              </template>
              <template v-slot:[`item.update`]="{ item }">
                <v-btn depressed color="warning" @click="edit(item)">更新する</v-btn>
              </template>
              <template v-slot:[`item.delete`]="{ item }">
                <v-btn depressed color="error" @click="destroy(item)" :disabled="item.selectable.type == 1">削除する {{
                  item.id
                }}</v-btn>
              </template>
            </v-data-table>
            <VDialog v-model="dialog">
              <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                  <v-card>
                    <v-card-title>Register/Update Category</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                      <v-row>
                        <v-col cols="12">
                          <label class="text-black font-weight-bold">Name
                            <span
                              class="text-red font-weight-bold">※
                            </span>
                          </label>
                          <v-text-field variant="outlined" prepend-inner-icon="mdi-email-outline" color="primary"
                            v-model="form.name" :rules="[rules.required]">
                          </v-text-field>
                        </v-col>
                        <v-col cols="12">
                          <label class="text-black font-weight-bold">Type
                            <span
                              class="text-red font-weight-bold">※
                            </span>
                          </label>
                          <v-select variant="outlined" color="primary" :items="typeSelects" v-model="form.type"
                            label="select one">
                          </v-select>
                        </v-col>
                        <v-col cols="12">
                          <label class="text-black font-weight-bold">Description
                            <span
                              class="text-red font-weight-bold">※
                            </span>
                          </label>
                          <v-text-field variant="outlined" color="primary" v-model="form.description" :rules="[rules.required]">
                          </v-text-field>
                        </v-col>
                        <v-col cols="12">
                          <label class="text-black font-weight-bold">Address
                            <span
                              class="text-red font-weight-bold">※
                            </span>
                          </label>
                          <v-text-field variant="outlined" color="primary" v-model="form.address" :rules="[rules.required]"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                          <label class="text-black font-weight-bold">Phone Number
                            <span
                              class="text-red font-weight-bold">※
                            </span>
                          </label>
                          <v-text-field variant="outlined" color="primary" v-model="form.phone_number" :rules="[rules.required]"></v-text-field>
                        </v-col>
                      </v-row>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions class="justify-center pa-4">
                      <v-row>
                        <v-col cols="6">
                          <v-btn depressed block color="warning" @click="save">Save</v-btn>
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
}

div.v-field__input {
  max-height: 56px !important;
}
</style>
