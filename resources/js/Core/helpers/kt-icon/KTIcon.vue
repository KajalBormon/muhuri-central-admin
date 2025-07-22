<template>
  <i
    :class="`ki-${currentIconType} ki-${props.iconName}${
      props.iconClass ? ' ' + props.iconClass : ''
    }`"
  >
    <template v-if="icons[props.iconName] && currentIconType === 'duotone'">
      <span
        v-for="i in icons[props.iconName]"
        :key="i"
        :class="`path${i}`"
      ></span>
    </template>
  </i>
</template>

<script setup lang="ts">
import { computed } from "vue";
import KTIcons from "@/Core/helpers/kt-icon/icons.json";
// import { useConfigStore } from "@/stores/config";

// const store = useConfigStore();

// Note: we need to define the type of icons, so we stored this in constant local variable named icons as following and in line 19 there was import icons, we changed that to KTIcons to remove conflicts. 
const icons: {[type:string]: number} = KTIcons || {};

const props = defineProps({
  iconName: { type: String, default: "", required: true },
  iconType: {
    type: String,
    default: "",
    required: false,
  },
  iconClass: { type: String, default: "", required: false },
});

const currentIconType = computed(() => {
  // return props.iconType ? props.iconType : store.config.general.iconsType;
    return props.iconType ? props.iconType : 'solid';
});
</script>
