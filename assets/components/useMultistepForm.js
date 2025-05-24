import { ref } from 'vue';

export function useMultistepForm(stepList) {
    
    const steps = stepList.map(step => ({...step}));
    const activeStepIndex = ref(0);
    const stepRefs = ref([]);

    function activateStep(index) {
        if (index >= 0 && index < steps.length) {
            activeStepIndex.value = index;
        }
    }

    return { steps, activeStepIndex, stepRefs, activateStep }
}