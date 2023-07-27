<script setup>
  import { onMounted, ref } from 'vue';

  defineProps({
    modelValue: {
      type: String,
      required: true,
    },
    options: {
      type: Array,
      required: true,
    },
  });

  defineEmits(['update:modelValue']);

//   const input = ref(null);

//   onMounted(() => {
//     if (input.value.hasAttribute('autofocus')) {
//       input.value.focus();
//     }
//   });

//   defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
     :value="modelValue" @change="(event) => $emit('update:modelValue', event.target.value)">
    <option v-for="option in options" :value="option.id" :key="option.id">
      {{ option.name }}
    </option>
  </select>
</template>
