<!-- Parent application_form component. Responsible for step switching and rendering -->

<script setup>
import FormStepPagination from './FormStepPagination';
import UserDataStep from './form_steps/UserDataStep.vue';
import ContactDataStep from './form_steps/ContactDataStep.vue';
import ExperienceDataStep from './form_steps/ExperienceDataStep.vue';
import { ref } from 'vue';
import { useMultistepForm } from './useMultistepForm';

const { steps, activeStepIndex, stepRefs, activateStep, allValid } =
useMultistepForm([
         { component: UserDataStep },
         { component: ContactDataStep },
         { component: ExperienceDataStep }
    ]);

function onSubmit(e) {
    const formValid = allValid();
    console.log('Valid: ', formValid);
    
    if (!formValid) return;

    console.log(payload);
}

async function submitForm() {
    const payload = {
        user: stepRefs.value[0].getData(),
        contact: stepRefs.value[1].getData(),
        experience: stepRefs.value[2].getData()
    };

    try {
        const response = await fetch('/submit-form', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload);
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.error || 'Error');
        }

        // Show submitted data
        // ...
        console.log("Submission successful");
    }
    catch (error) {
        // Show submission error
        // ...
        console.log("Error on submission: ", error.message);
    }
}

const paginator = ref(null);

function onPaginatorSelect(index) {
    if (index < 0 || index > (steps.length - 1)) return false;

    activateStep(index);
}

</script>

<!-- "required" depends on active index to avoid validation pop-ups on inactive steps. Validation scripts still prevent form submission -->
<template>
<div class="form-container bg-light p-3 rounded shadow">
    <form @submit.prevent="onSubmit">
        <div id="form-steps-container">
            <div
            class="form-step"
            v-for="(step, index) in steps"
            :key="index"
            :class="{
                active: index === activeStepIndex,
                previous: index < activeStepIndex,
                next: index > activeStepIndex
            }"
            >
                <component
                    :is="step.component"
                    :ref="el => stepRefs[index] = el"
                    :required="index === activeStepIndex"
                />
            </div>
        </div>
        <div class="bottom-row mt-3">
            <div class="row g-2 flex-column flex-md-row">
                <div class="col">
                    <FormStepPagination ref="paginator" 
                    :steps="steps" :active="activeStepIndex"
                    @selected="(index) => {onPaginatorSelect(index)}" 
                    />
                </div>
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
</template>