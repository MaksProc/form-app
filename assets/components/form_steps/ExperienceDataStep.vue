<!-- Third form step. Fields: company name, job title, beginning and end dates - in rows of expandable table -->

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import { useStepValidation } from './useStepValidation';
import ExperienceInput from '../form_inputs/compound/ExperienceInput.vue';

const { registerInput, validateStep } = useStepValidation();

const experienceInput = ref(null);

onMounted(() => {
   registerInput(experienceInput);
})

defineExpose({
    validateStep
})

</script>

<template>
    <ExperienceInput id="1" ref="experienceInput" />
</template>