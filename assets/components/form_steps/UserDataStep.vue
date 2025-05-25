<!-- First form step. Fields: name, surname, birthday -->

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import NameInput from '../form_inputs/namelike/NameInput.vue';
import { useStepValidation } from './useStepValidation';
import BirthdayInput from '../form_inputs/date/BirthdayInput.vue';

const props = defineProps({
    required: {
        type: Boolean,
        default: false
    }
})

const nameInput = ref(null);
const surnameInput = ref(null);
const birthdayInput = ref(null);

const { registerInput, validateStep } = useStepValidation();

onMounted(() => {
    registerInput(nameInput);
    registerInput(surnameInput);
    registerInput(birthdayInput);
})

function getData() {
    return {
        name: nameInput.value.getData(),
        surname: surnameInput.value.getData(),
        birthday: birthdayInput.value.getData()
    };
}

defineExpose({
    validateStep,
    getData
})

</script>

<template>
    <NameInput label="Name" id="name" ref="nameInput" :required="required" />
    <NameInput label="Surname" id="surname" ref="surnameInput" :required="required" />
    <BirthdayInput label="Birthday date" id="birthday" ref="birthdayInput" :required="required" />
</template>