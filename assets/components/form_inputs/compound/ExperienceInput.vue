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
    },
    required: {
        type: Boolean,
        default: false
    }
})

const helpMsg = ref('');
const daterangeInput = ref(null);
const companyName = ref('');
const titleName = ref('');

const { value: yourvmodel, validate } = useInputValidation(val => {
    // Make validity checks here
    if (!daterangeInput.value.validate()) {
        return false;
    }
    
    if (companyName.value === '' || titleName.value === '') {
        helpMsg.value="Provide both company name and your job title";
        return false;
    }
    
    helpMsg.value = ''
    return true;
})

defineExpose({ 
    validate
});


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
    <tr class="form-group">
        <td>
            <input 
            type="text"
            id="{{id}}-company" 
            v-model="companyName" 
            @input="onCompanyInput" 
            class="form-control"
            :required="required"
            />
        </td>
        <td>
            <input 
            type="text" 
            id="{{id}}-title" 
            v-model="titleName" 
            @input="onTitleInput" 
            class="form-control"
            :required="required"
            />
        </td>
        <DaterangeInput id="{{ id }}-experience" ref="daterangeInput" @helpMsg="(msg) => helpMsg = msg" :required="required"/>
    </tr>
    <tr v-if="helpMsg">
        <td colspan="4">
            <small class="form-text text-danger">{{ helpMsg }}</small>
        </td>
    </tr>
</template>