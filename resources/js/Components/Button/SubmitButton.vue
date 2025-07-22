<template>
    <button type="submit" class="btn btn-primary" ref="submitButton" @click="handleSubmit">
        <span v-if="!props.buttonValue" class="indicator-label">
            {{ (props.id || props.obj)? $t('buttonValue.update') : $t('buttonValue.submit') }}
        </span>
        <span v-else class="indicator-label">{{ props.buttonValue }}</span>
        <span class="indicator-progress">{{ $t('confirmation.wait') }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    </button>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const submitButton = ref<HTMLElement | null>(null);

const props = defineProps({
    id: Number,
    obj: Object,
    buttonValue: String
});

const handleSubmit = () => {
    if (submitButton.value) {
        // Activate indicator
        submitButton.value.setAttribute("data-kt-indicator", "on");
        setTimeout(() => {
            submitButton.value ?.removeAttribute("data-kt-indicator");
        }, 2000);
    }
}
</script>
