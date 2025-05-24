<!-- First form step. Fields: name, surname, birthday -->

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import NameInput from '../form_inputs/namelike/NameInput.vue';
import { useStepValidation } from './useStepValidation';
import BirthdayInput from '../form_inputs/date/BirthdayInput.vue';

const nameInput = ref(null);
const surnameInput = ref(null);
const birthdayInput = ref(null);

const { registerInput, validateStep } = useStepValidation();

onMounted(() => {
    registerInput(nameInput);
    registerInput(surnameInput);
    registerInput(birthdayInput);
})

defineExpose({
    validateStep
})

</script>

<template>
    <NameInput label="Name" id="name" ref="nameInput"/>
    <NameInput label="Surname" id="surname" ref="surnameInput" />
    <BirthdayInput label="Birthday date" id="birthday" ref="birthdayInput" />
</template>