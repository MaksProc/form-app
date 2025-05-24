<!-- Third form step. Fields: company name, job title, beginning and end dates - in rows of expandable table -->

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import { useStepValidation } from './useStepValidation';

const { registerInput, validateStep } = useStepValidation();

onMounted(() => {

})

defineExpose({
    validateStep
})

</script>

<template>

</template>