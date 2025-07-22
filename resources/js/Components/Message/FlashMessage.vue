<template>
</template>

<script setup lang="ts">
import toastr from 'toastr';
import 'toastr/toastr.scss';
const props = defineProps({
    flash: Object,
})
if(props.flash && props.flash.success) {
    toastr.success(props.flash.success)
    props.flash.success = null;
} else if (props.flash && props.flash.error){
    toastr.error(props.flash.error)
    props.flash.error = null;
}

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "showDuration": 300,
  "hideDuration": 1000,
  "timeOut": 5000,
  "extendedTimeOut": 1000,
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
</script>
