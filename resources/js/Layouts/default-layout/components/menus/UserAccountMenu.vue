<template>
    <!--begin::Menu-->
    <div
      class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold py-4 fs-6 w-275px"
      data-kt-menu="true"
    >
      <!--begin::Menu item-->
      <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
          <!--begin::Avatar-->
          <div class="symbol symbol-50px me-5">
            <!-- <img alt="Logo" :src="getAssetPath('media/avatars/300-3.jpg')" /> -->
            <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getInitials(user) }}</div>
          </div>
          <!--end::Avatar-->

          <!--begin::Username-->
          <div class="d-flex flex-column">
            <div class="fw-bold d-flex align-items-center fs-5">
              {{ name }}
              <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"
                >Pro</span
              >
            </div>
            <Link :href="''" class="fw-semibold text-muted text-hover-primary fs-7"
              >{{ email }}</Link
            >
          </div>
          <!--end::Username-->
        </div>
      </div>
      <!--end::Menu item-->

      <!--begin::Menu separator-->
      <div class="separator my-2"></div>
      <!--end::Menu separator-->

      <!--begin::Menu item-->
      <div class="menu-item px-5">
        <Link :href="route('profile.edit')" class="menu-link px-5">
          {{$t('user.header.profile.edit')}}
        </Link>

      </div>
      <!--end::Menu item-->

      <!--begin::Menu item-->
      <div class="menu-item px-5">
        <Link :href="''" @click="signOut()" class="menu-link px-5"> {{ $t('buttonValue.signOut') }} </Link>
      </div>
      <!--end::Menu item-->
    </div>
    <!--end::Menu-->
  </template>

  <script lang="ts" setup>
  import { getAssetPath } from "@/Core/helpers/Assets";
  import { computed, defineComponent } from "vue";
  import { useI18n } from "vue-i18n";
  import { useAuthStore } from "@/Stores/auth";
  import { useRouter } from "vue-router";
  import { Link, router } from '@inertiajs/vue3'
  import { usePage } from '@inertiajs/vue3';
  import { getInitials } from '@/Core/helpers/Helper';

  const vRouter = useRouter();
  const i18n = useI18n();
  const store = useAuthStore();

  const user = usePage().props.auth.user;
  const {name} = user;
  const {email} = user;

  i18n.locale.value = localStorage.getItem("lang")
      ? (localStorage.getItem("lang") as string)
      : "en";

  const countries = {
      en: {
      flag: getAssetPath("/media/flags/united-states.svg"),
      name: "English",
      },
      es: {
      flag: getAssetPath("/media/flags/spain.svg"),
      name: "Spanish",
      },
      de: {
      flag: getAssetPath("/media/flags/germany.svg"),
      name: "German",
      },
      ja: {
      flag: getAssetPath("/media/flags/japan.svg"),
      name: "Japanese",
      },
      fr: {
      flag: getAssetPath("/media/flags/france.svg"),
      name: "French",
      },
  };

  const signOut = () => {
      localStorage.removeItem('permissions');
      router.post('/logout/');
  };

  const setLang = (lang: string) => {
      localStorage.setItem("lang", lang);
      i18n.locale.value = lang;
  };

  const currentLanguage = computed(() => {
      return i18n.locale.value;
  });

  const currentLangugeLocale = computed(() => {
      return countries[i18n.locale.value as keyof typeof countries];
  });
  </script>
