<!-- Form input component for one capitalized word -->
<!-- Used here for User's name and surname -->

<script setup>
import { useTemplateRef, ref } from 'vue';
import { useInputValidation } from '../useInputValidation';


const props = defineProps({
    label: {
        type: String,
        default: "Name"
    },
    id: {
        type: String,
        required: true
    }
})

const { value: name, validate } = useInputValidation(val => {
    // Make validity checks here

    if (!name.value) {
        return false
    }

    return true
})

defineExpose({ validate });


// User experience
import { useCapitalizeText } from './useCapitalizeText';
const capitalize = useCapitalizeText();

function onInput(e) {
    // Capitalize input
    name.value = capitalize(name.value)
    
}

</script>

<template>
    <div class="form-group">
        <label :for="id">{{ label }}: </label>
        <input type="text" :id="id" v-model="name" @input="onInput" class="form-control"/>
    </div>
</template>