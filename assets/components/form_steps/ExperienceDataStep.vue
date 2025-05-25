<!-- Third form step. Fields: company name, job title, beginning and end dates - in rows of expandable table -->

<script setup>
import { onMounted, onUnmounted, ref, reactive, nextTick } from 'vue';
import { useStepValidation } from './useStepValidation';
import ExperienceInput from '../form_inputs/compound/ExperienceInput.vue';

const { registerInput, validateStep } = useStepValidation();

const props = defineProps({
    required: {
        type: Boolean,
        default: false
    }
})

const experienceInput = ref(null);

let idCounter = 0;
const experiences = reactive([]);
const experienceRefs = [];

onMounted(() => {
})

defineExpose({
    validateStep
})

function addExperience() {
    experiences.push({
        id: idCounter++,
        company: '',
        title: '',
        startDate: '',
        endDate: '',
        helpMsg: ''
    })

    nextTick(() => {
        const newRef = experienceRefs[experienceRefs.length - 1];
        if (newRef) {
            registerInput(newRef);
        }
    })
}

addExperience();

</script>

<template>
    <table class="table table-borderless align-middle">
        <thead>
            <tr>
                <th scope="col">Work place</th>
                <th scope="col">Job title</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
            </tr>
        </thead>
        <tbody>
            <ExperienceInput 
                v-for="(exp, index) in experiences" 
                :key="exp.id" 
                :id="String(index)" 
                :ref="el => experienceRefs[index] = el"
                :required="required"
            />
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <button type="button" class="btn btn-outline-primary w-100" @click="addExperience">
                        + Add row
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</template>