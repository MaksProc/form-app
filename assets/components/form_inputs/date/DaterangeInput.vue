<!-- Input for two dates where one must be later than the other -->

<script setup>
import { ref, computed, watch } from 'vue';
import { useInputValidation } from '../useInputValidation';


const props = defineProps({
    label: {
        type: String,
        default: "Date range"     // Change default label
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

const emit = defineEmits(['helpMsg']);
watch(helpMsg, (newMsg) => {
    emit('helpMsg', String(newMsg));
})

// User experience, input limitations
function onInput(e) {
    
}

</script>

<template>
    <td>
        <input 
            type="date" 
            id="{{ id }}-start" 
            v-model="dateStart" 
            @input="onInput" 
            class="form-control"
            :required="required"
        />
    </td>
    <td>
        <input 
            type="date" 
            id="{{ id }}-end" 
            v-model="dateEnd" 
            @input="onInput" 
            class="form-control" 
            :required="required"
        />
    </td>
</template>