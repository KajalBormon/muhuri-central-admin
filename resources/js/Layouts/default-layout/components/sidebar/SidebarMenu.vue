<template>
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div
            id="kt_app_sidebar_menu_wrapper"
            class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true"
            data-kt-scroll-activate="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu"
            data-kt-scroll-offset="5px"
            data-kt-scroll-save-state="true"
        >
            <!--begin::Menu-->
            <div
                id="#kt_app_sidebar_menu"
                class="menu menu-column menu-rounded menu-sub-indention px-3"
                data-kt-menu="true"
            >
                <template v-for="(item, i) in MainMenuConfig" :key="i">
                    <div v-if="item.heading" class="menu-item pt-5">
                        <div class="menu-content" v-if="checkMenuPermission(item.headingPermissions)">
                          <span class="menu-heading fw-bold text-uppercase fs-7">
                            {{ translate(item.heading) }}
                          </span>
                        </div>
                    </div>
                    <template v-for="(menuItem, j) in item.pages" :key="j">
                        <template v-if="menuItem.heading">
                            <div class="menu-item">
                                <a
                                    v-if="menuItem.route && checkMenuPermission(menuItem.routePermissions)"
                                    class="menu-link"
                                    :class="{ active: isMenuItemActive(menuItem.route) }"
                                    :href="menuItem.route"
                                >
                                    <span
                                      v-if="menuItem.keenthemesIcon || menuItem.bootstrapIcon"
                                      class="menu-icon"
                                    >
                                        <i
                                            v-if="sidebarMenuIcons === 'bootstrap'"
                                            :class="menuItem.bootstrapIcon"
                                            class="bi fs-3"
                                        ></i>
                                        <KTIcon
                                            v-else-if="sidebarMenuIcons === 'keenthemes'"
                                            :icon-name="menuItem.keenthemesIcon"
                                            icon-class="fs-2"
                                        />
                                    </span>
                                    <span class="menu-title">{{ translate(menuItem.heading) }}</span>
                                </a>
                            </div>
                        </template>
                        <div
                            v-if="menuItem.sectionTitle && menuItem.routeArray"
                            :class="{ show: hasActiveChildren(menuItem.routeArray) }"
                            class="menu-item menu-accordion"
                            data-kt-menu-sub="accordion"
                            data-kt-menu-trigger="click"
                        >
                            <span class="menu-link" v-if="checkMenuPermission(menuItem.routePermissions)">
                                <span
                                    v-if="menuItem.keenthemesIcon || menuItem.bootstrapIcon"
                                    class="menu-icon"
                                >
                                    <i
                                        v-if="sidebarMenuIcons === 'bootstrap'"
                                        :class="menuItem.bootstrapIcon"
                                        class="bi fs-3"
                                    ></i>
                                    <KTIcon
                                        v-else-if="sidebarMenuIcons === 'keenthemes'"
                                        :icon-name="menuItem.keenthemesIcon"
                                        icon-class="fs-2"
                                    />
                                </span>
                                <span class="menu-title">{{ translate(menuItem.sectionTitle) }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div
                                :class="{ show:hasActiveChildren(menuItem.routeArray) }"
                                class="menu-sub menu-sub-accordion"
                            >
                                <template v-for="(item2, k) in menuItem.sub" :key="k">
                                    <div v-if="item2.heading && checkRoutePermission(item2.permission)" class="menu-item">
                                        <a
                                            v-if="item2.route"
                                            class="menu-link"
                                            :class="{ active: isMenuItemActive(item2.route) }"
                                            :href="item2.route"
                                        >
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ translate(item2.heading)}}</span>
                                        </a>
                                    </div>
                                    <div
                                        v-if="item2.sectionTitle && item2.route"
                                        :class="{ show: hasActiveChildren(item2.route) }"
                                        class="menu-item menu-accordion"
                                        data-kt-menu-sub="accordion"
                                        data-kt-menu-trigger="click"
                                    >
                                        <span class="menu-link">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{translate(item2.sectionTitle)}}</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div
                                            :class="{ show: hasActiveChildren(item2.route) }"
                                            class="menu-sub menu-sub-accordion"
                                        >
                                            <template v-for="(item3, k) in item2.sub" :key="k">
                                                <div v-if="item3.heading" class="menu-item">
                                                    <a
                                                        v-if="item3.route"
                                                        class="menu-link"
                                                        :class="{ active: isMenuItemActive(item3.route) }"
                                                        :href="item3.route"
                                                    >
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">{{translate(item3.heading)}}</span>
                                                    </a>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</template>

<script lang="ts">
// import { getAssetPath } from "@/core/helpers/assets";
import {computed, defineComponent, onMounted, ref} from "vue";
// import { useRoute } from "vue-router";
import MainMenuConfig from "@/Layouts/default-layout/config/MainMenuConfig";
// import {sidebarMenuIcons} from "@/Layouts/default-layout/config/helper";
// import {useI18n} from "vue-i18n";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";

export default defineComponent({
    name: "sidebar-menu",
    components: {KTIcon},
    setup() {
        // const { t, te } = useI18n();
        const scrollElRef = ref<null | HTMLElement>(null);

        onMounted(() => {
          if (scrollElRef.value) {
            scrollElRef.value.scrollTop = 0;
          }
        });

        const translate = (text: string) => {
            return text;
            // if (te(text)) {
            //   return t(text);
            // } else {
            //   return text;
            // }
        };
        const url = window.location.pathname;
        const isMenuItemActive = (route: string) => {
            return url.includes(route) || url.split('/').some(part => part === route);
            // return url === route;
        };
        // const hasActiveChildren = (match: string) => {
        //     return  url?.indexOf(match) !== -1;
        // };
        const hasActiveChildren = (routes: string|string[]) => {
            if (typeof routes === 'string') {
                return url.indexOf(routes) !== -1;
            } else {
                return routes.some(route => url.indexOf(route) !== -1);
            }
        };

        const allPermissions = JSON.parse(localStorage.getItem('permissions') || '[]');

        // route permission checking
        const checkRoutePermission = (routePermission: any) => {
            return allPermissions.some((element: any) => {
                return element.name === routePermission
            });
        };

        // Menu and Heading section permission checking
        const checkMenuPermission = (menuPermissions: any) => {
            if(!menuPermissions) return true;
            return allPermissions.some((element: any) => {
                return menuPermissions.some((menuPermission: any) => {
                    return element.name === menuPermission
                });
            });
        }
        return {
            hasActiveChildren,
            isMenuItemActive,
            MainMenuConfig,
            sidebarMenuIcons: "keenthemes",
            translate,
            checkRoutePermission,
            checkMenuPermission
            // getAssetPath,
        };
    },
});
</script>
