<!-- Copy and change this to make an input component -->

<script setup>
import { ref } from 'vue';
import { useInputValidation } from '../useInputValidation';


const props = defineProps({
    label: {
        type: String,
        default: "CHANGEME"     // Change default label
    },
    id: {
        type: String,
        required: true
    },
    required: {
        type: Boolean,
        default: false
    }
})

const helpMsg = ref('');

const { value: yourvmodel, validate } = useInputValidation(val => {     // Change "yourvmodel" to the input ref
    // Make validity checks here
    
    return true
})

defineExpose({ validate });


// User experience, input limitations
function onInput(e) {
    
}

</script>

<template>
    <div class="form-group">
        <label :for="id">{{ label }}: </label>
        <input type="text" :id="id" v-model="changeme" @input="onInput" class="form-control" :required="required"/> <!-- Set v-model -->
        <small class="form-text text-danger">{{ helpMsg }}</small>
    </div>
</template>