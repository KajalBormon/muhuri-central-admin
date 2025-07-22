<template>
  <!--begin::Menu-->
  <div
    class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px"
    data-kt-menu="true"
  >
    <!--begin::Heading-->
    <div
      class="d-flex flex-column bgi-no-repeat rounded-top"
      :style="`background-image: url('${getAssetPath(
        '/media/misc/menu-header-bg.jpg'
      )}')`"
    >
      <!--begin::Title-->
      <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
        Notifications <span class="fs-8 opacity-75 ps-3">24 reports</span>
      </h3>
      <!--end::Title-->

      <!--begin::Tabs-->
      <ul
        class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9"
      >
        <li class="nav-item">
          <a
            class="nav-link text-white opacity-75 opacity-state-100 pb-4"
            data-bs-toggle="tab"
            href="#kt_topbar_notifications_1"
            @click="activeTab = 1"
            :class="{ 'active': activeTab === 1 }"
            >Alerts</a
          >
        </li>

        <li class="nav-item">
          <a
            class="nav-link text-white opacity-75 opacity-state-100 pb-4"
            data-bs-toggle="tab"
            href="#kt_topbar_notifications_2"
            @click="activeTab = 2"
            :class="{ 'active': activeTab === 2 }"
            >Updates</a
          >
        </li>

        <li class="nav-item">
          <a
            class="nav-link text-white opacity-75 opacity-state-100 pb-4"
            data-bs-toggle="tab"
            href="#kt_topbar_notifications_3"
            @click="activeTab = 3"
            :class="{ 'active': activeTab === 3 }"
            >Logs</a
          >
        </li>
      </ul>
      <!--end::Tabs-->
    </div>
    <!--end::Heading-->

    <!--begin::Tab content-->
    <div class="tab-content">
      <!--begin::Tab panel-->
      <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel" v-show="activeTab === 1">
        <!--begin::Items-->
        <div class="scroll-y mh-325px my-5 px-8">
          <template v-for="(item, index) in data1" :key="index">
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
              <!--begin::Section-->
              <div class="d-flex align-items-center">
                <!--begin::Symbol-->
                <div class="symbol symbol-35px me-4">
                  <span :class="`bg-light-${item.state}`" class="symbol-label">
                    <KTIcon
                      :icon-name="item.icon"
                      :icon-class="`text-${item.state}`"
                    />
                  </span>
                </div>
                <!--end::Symbol-->

                <!--begin::Title-->
                <div class="mb-0 me-2">
                  <a
                    href="#"
                    class="fs-6 text-gray-800 text-hover-primary fw-bold"
                    >{{ item.title }}</a
                  >
                  <div class="text-gray-500 fs-7">
                    {{ item.description }}
                  </div>
                </div>
                <!--end::Title-->
              </div>
              <!--end::Section-->

              <!--begin::Label-->
              <span class="badge badge-light fs-8">{{ item.time }}</span>
              <!--end::Label-->
            </div>
            <!--end::Item-->
          </template>
        </div>
        <!--end::Items-->

        <!--begin::View more-->
        <div class="py-3 text-center border-top">
          <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">
            View All
            <KTIcon icon-name="arrow-right" icon-class="fs-5" />
          </a>
        </div>
        <!--end::View more-->
      </div>
      <!--end::Tab panel-->

      <!--begin::Tab panel-->
      <div
        class="tab-pane fade show active"
        id="kt_topbar_notifications_2"
        role="tabpanel"
        v-show="activeTab === 2"
      >
        <!--begin::Wrapper-->
        <div class="d-flex flex-column px-9">
          <!--begin::Section-->
          <div class="pt-10 pb-0">
            <!--begin::Title-->
            <h3 class="text-gray-900 text-center fw-bold">Get Pro Access</h3>
            <!--end::Title-->

            <!--begin::Text-->
            <div class="text-center text-gray-600 fw-semibold pt-1">
              Outlines keep you honest. They stoping you from amazing poorly
              about drive
            </div>
            <!--end::Text-->

            <!--begin::Action-->
            <div class="text-center mt-5 mb-9">
              <a
                href="#"
                class="btn btn-sm btn-primary px-6"
                data-bs-toggle="modal"
                data-bs-target="#kt_modal_upgrade_plan"
                >Upgrade</a
              >
            </div>
            <!--end::Action-->
          </div>
          <!--end::Section-->

          <!--begin::Illustration-->
          <img
            class="mw-100 mh-200px"
            alt="metronic"
            :src="getIllustrationsPath('1.png')"
          />
          <!--end::Illustration-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Tab panel-->

      <!--begin::Tab panel-->
      <div class="tab-pane fade show active" id="kt_topbar_notifications_3" role="tabpanel" v-show="activeTab === 3">
        <!--begin::Items-->
        <div class="scroll-y mh-325px my-5 px-8">
          <template v-for="(item, index) in data2" :key="index">
            <!--begin::Item-->
            <div class="d-flex flex-stack py-4">
              <!--begin::Section-->
              <div class="d-flex align-items-center me-2">
                <!--begin::Code-->
                <span
                  class="w-70px badge me-4"
                  :class="`badge-light-${item.state}`"
                  >{{ item.code }}</span
                >
                <!--end::Code-->

                <!--begin::Title-->
                <a
                  href="#"
                  class="text-gray-800 text-hover-primary fw-semibold"
                  >{{ item.message }}</a
                >
                <!--end::Title-->
              </div>
              <!--end::Section-->

              <!--begin::Label-->
              <span class="badge badge-light fs-8">{{ item.time }}</span>
              <!--end::Label-->
            </div>
            <!--end::Item-->
          </template>
        </div>
        <!--end::Items-->

        <!--begin::View more-->
        <div class="py-3 text-center border-top">
          <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">
            View All
            <KTIcon icon-name="arrow-right" icon-class="fs-5" />
          </a>
        </div>
        <!--end::View more-->
      </div>
      <!--end::Tab panel-->
    </div>
    <!--end::Tab content-->
  </div>
  <!--end::Menu-->
</template>

<script lang="ts">
import { getAssetPath, getIllustrationsPath } from "@/Core/helpers/Assets";
import { defineComponent, ref } from "vue";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
export default defineComponent({
  name: "notifications-menu",
  components: {},
  setup() {
    const activeTab = ref(2);
    const data1 = [
      {
        title: "Project Alice",
        description: "Phase 1 development",
        time: "1 hr",
        icon: "technology-2",
        state: "primary",
      },
      {
        title: "HR Confidential",
        description: "Confidential staff documents",
        time: "2 hrs",
        icon: "information-5",
        state: "danger",
      },
    ];

    const data2 = [
      {
        code: "200 OK",
        state: "success",
        message: "New order",
        time: "Just now",
      },
      {
        code: "500 ERR",
        state: "danger",
        message: "New customer",
        time: "2 hrs",
      },
    ];
    function firtTab() {
        console.log('ok');
    }
    return {
      data1,
      data2,
      getIllustrationsPath,
      getAssetPath,
      activeTab,
    };
  },
});
</script>
