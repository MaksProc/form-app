<!-- Input for two dates where one must be later than the other -->

<script setup>
import { ref, computed } from 'vue';
import { useInputValidation } from '../useInputValidation';


const props = defineProps({
    label: {
        type: String,
        default: "Date range"     // Change default label
    },
    id: {
        type: String,
        required: true
    }
})

const helpMsg = ref('');

const dateStart = ref('');
const dateEnd = ref('');

const dateRange = computed(() => ({
    start: dateStart.value,
    end: dateEnd.value
}))

function validateDateRange({ start, end }) {
    helpMsg.value = '';
    if (!start || !end) {
        helpMsg.value = 'Provide both start and end date'
        return false;
    };

    const chosenStartDate = new Date(start);
    const chosenEndDate = new Date(end);

    if (chosenEndDate <= chosenStartDate) {
        helpMsg.value = 'End date must be later than start date'
        return false;
    }

    return true;
}

const { validate, isValid } = useInputValidation(
    validateDateRange,
    dateRange  
);

defineExpose({ validate });


// User experience, input limitations
function onInput(e) {
    
}

</script>

<template>
    <div class="form-group row">
        <input type="date" id="{{ id }}-start" v-model="dateStart" @input="onInput" class="form-control"/>
        <input type="date" id="{{ id }}-end" v-model="dateEnd" @input="onInput" class="form-control" />

        <small class="form-text text-danger">{{ helpMsg }}</small>
    </div>
</template>