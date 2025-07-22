<template>
  <div class="mb-4">
    <!--begin::Heading-->
    <div class="d-flex flex-stack fw-semibold mb-4">
      <!--begin::Label-->
      <span class="text-muted fs-6 me-2">Recently Searched:</span>
      <!--end::Label-->
    </div>
    <!--end::Heading-->
    <!--begin::Items-->
    <div class="scroll-y mh-200px mh-lg-325px">
      <!--begin::Item-->
      <div class="d-flex align-items-center mb-5">
        <!--begin::Symbol-->
        <div class="symbol symbol-40px symbol-circle me-4">
          <span class="symbol-label bg-light">
            <KTIcon icon-name="phone" icon-class="fs-2 text-primary" />
          </span>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column">
          <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold"
            >BoomApp by Keenthemes</a
          >
          <span class="fs-7 text-muted fw-semibold">#45789</span>
        </div>
        <!--end::Title-->
      </div>
      <!--end::Item-->

      <!--begin::Item-->
      <div class="d-flex align-items-center mb-5">
        <!--begin::Symbol-->
        <div class="symbol symbol-40px symbol-circle me-4">
          <span class="symbol-label bg-light">
            <KTIcon icon-name="chart" icon-class="fs-2 text-primary" />
          </span>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column">
          <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-semibold"
            >"Landing UI Design" Launch</a
          >
          <span class="fs-7 text-muted fw-semibold">#24005</span>
        </div>
        <!--end::Title-->
      </div>
      <!--end::Item-->
    </div>
    <!--end::Items-->
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/Core/helpers/Assets";
import { defineComponent } from "vue";

export default defineComponent({
  name: "kt-main",
  components: {},
  setup() {
    return {
      getAssetPath,
    };
  },
});
</script>
