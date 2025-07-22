<template>
    <!--begin::Language toggle-->
    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="hover" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
        <span v-if="languages && languages?.length != 0">
            <span v-for="language in languages" :key="language?.id">
                <a v-if="translate?.locale?.value == language?.code">
                    <span>{{ getUppercase(language) }}</span>
                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                </a>
            </span>
        </span>
        <span v-else>
            <span>EN</span>
            <i class="ki-duotone ki-down fs-5 ms-1"></i>
        </span>
    </a>
    <!--end::Language toggle-->

    <!--begin::Menu toggle-->
    <div
        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-60px, 245px);" data-popper-placement="bottom-end"
    >
        <!--begin::Menu item-->
        <span v-if="languages && languages?.length != 0">
            <div class="menu-item px-3 my-0" v-for="language in languages" :key="language?.id">
                <a
                    :href="route('localization', language?.code)"
                    class="menu-link px-3 py-2"
                    :class="{ active: translate?.locale?.value == language?.code }"
                    @click="changeLanguage(language?.code)"
                >
                    <span class="menu-title">{{ language?.name }} - {{ getUppercase(language) }}</span>
                </a>
            </div>
        </span>
        <span v-else>
            <a
                :href="route('localization', 'en')"
                class="menu-link px-3 py-2"
                :class="{ active: translate?.locale?.value == 'en' }"
                @click="changeLanguage('en')"
            >
                <span class="menu-title">English - EN</span>
            </a>
        </span>
    </div>
    <!--end::Menu toggle-->
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useI18n } from "vue-i18n";
import {getLanguages, getUppercase} from '@/Core/helpers/Helper';

const translate = useI18n();

const changeLanguage = (lang) => {
    translate.locale.value = lang;
    localStorage.setItem('locale', translate?.locale?.value);
};

const languages = ref([]);

onMounted(async () => {
    const storedLocale = localStorage.getItem('locale');
    const storedLanguages = localStorage.getItem('languages');

    if (storedLocale) {
        translate.locale.value = storedLocale;
    }

    if (storedLanguages) {
        languages.value = JSON.parse(storedLanguages);
    } else {
        const response = await getLanguages();
        const { languageOptions } = response.data?.data;
        languages.value = languageOptions;
        localStorage.setItem('languages', JSON.stringify(languageOptions));
    }
});
</script>
