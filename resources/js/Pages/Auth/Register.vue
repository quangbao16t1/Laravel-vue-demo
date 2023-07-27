<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectBoxCustom from '@/Components/SelectBoxCustom.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  role_id: '',
  password: '',
  password_confirmation: '',
});

const roles = ref([
  { id: 1, name: "Admin" },
  { id: 2, name: "Manager" },
  { id: 3, name: "Customer" },
  { id: 4, name: "Guest" }
]);

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};

</script>

<template>
  <GuestLayout>

    <Head title="Register" />

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="first_name" value="First Name" />

        <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required autofocus
          autocomplete="first_name" />

        <InputError class="mt-2" :message="form.errors.first_name" />
      </div>

      <div>
        <InputLabel for="last_name" value="Last Name" />

        <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required autofocus
          autocomplete="last_name" />

        <InputError class="mt-2" :message="form.errors.last_name" />
      </div>

      <div class="mt-4">
        <InputLabel for="email" value="Email" />

        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
          autocomplete="username" />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="role_id" value="Role" />

        <SelectBoxCustom id="role_id" class="mt-1 block w-full" v-model="form.role_id" :options="roles"
          required autocomplete="role_id" />

        <InputError class="mt-2" :message="form.errors.role_id" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />

        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
          autocomplete="new-password" />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" value="Confirm Password" />

        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
          v-model="form.password_confirmation" required autocomplete="new-password" />

        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link :href="route('login')"
          class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Already registered?
        </Link>

        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Register
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
