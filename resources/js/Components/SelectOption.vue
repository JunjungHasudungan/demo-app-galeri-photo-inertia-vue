<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        v-model="model"
        ref="input"
    >
    <option value="" disabled>Pilih kategori</option>
        <option
            v-for="category in categories"
            :key="category.value"
            :value="category.value"
        >
            {{ category.label }}
        </option>
    </select>
</template>
