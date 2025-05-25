<!-- Copy and change this to make an input component -->

<script setup>
import { ref } from 'vue';
import { useInputValidation } from '../useInputValidation';
import DaterangeInput from '../date/DaterangeInput.vue';


const props = defineProps({
    label: {
        type: String,
        default: "Experience"
    },
    id: {
        type: String,
        required: true
    }
})

const helpMsg = ref('');
const daterangeInput = ref(null);

const { value: yourvmodel, validate } = useInputValidation(val => {
    // Make validity checks here
    if (!daterangeInput.value.validate()) {
        console.log("daterange validity checked and failed")
        return false;
    }

    return true;
})

defineExpose({ validate });


// User experience, input limitations
function onCompanyInput(e) {
    const raw = e.target.value;
    let formatted = raw;
    formatted = formatted.slice(0, 254);

    companyName.value = formatted;
}

function onTitleInput(e) {
    const raw = e.target.value;
    let formatted = raw;
    formatted = formatted.slice(0, 254);

    titleName.value = formatted;
}

</script>

<template>
    <div class="form-group">
        <input type="text" id="{{id}}-company" v-model="companyName" @input="onCompanyInput" class="form-control"/>
        <input type="text" id="{{id}}-title" v-model="titleName" @input="onTitleInput" class="form-control"/>
        <DaterangeInput id="{{ id }}-experience" ref="daterangeInput"/>
        <small class="form-text text-danger">{{ helpMsg }}</small>
    </div>
</template>