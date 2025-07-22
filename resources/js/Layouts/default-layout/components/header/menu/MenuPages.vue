<template>
  <template v-for="(item, i) in MainMenuConfig" :key="i">
    <template v-if="!item.heading">
      <template v-for="(menuItem, j) in item.pages" :key="j">
        <div v-if="menuItem.heading" class="menu-item me-lg-1">
          <a
            v-if="menuItem.route"
            class="menu-link"
            :href="menuItem.route"
            :class="{ active: hasActiveChildren(menuItem.route) }"
          >
            <span class="menu-title">{{ translate(menuItem.heading) }}</span>
        </a>
        </div>
      </template>
    </template>
    <div
      v-if="item.heading && checkMenuPermission(item.headingPermissions)"
      data-kt-menu-trigger="click"
      data-kt-menu-placement="bottom-start"
      class="menu-item menu-lg-down-accordion me-lg-1"
    >
      <span
        v-if="item.route"
        class="menu-link py-3"
        :class="{ active: hasActiveChildren(item.headingRoutes) }"
      >
        <span class="menu-title">{{ translate(item.heading) }}</span>
        <span class="menu-arrow d-lg-none"></span>
      </span>
      <div
        class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px"
      >
        <template v-for="(menuItem, j) in item.pages" :key="j">
          <div
            v-if="menuItem.sectionTitle && menuItem.routeArray && checkMenuPermission(menuItem.routePermissions)"
            data-kt-menu-trigger="{default:'click', lg: 'hover'}"
            data-kt-menu-placement="right-start"
            class="menu-item menu-lg-down-accordion"
          >
            <span
              v-if="menuItem.route"
              class="menu-link py-3"
              :class="{ active: hasActiveChildren(menuItem.routeArray) }"
            >
              <span class="menu-icon">
                <i
                  v-if="headerMenuIcons === 'bootstrap'"
                  :class="menuItem.bootstrapIcon"
                  class="bi fs-3"
                ></i>
                <KTIcon
                  v-if="headerMenuIcons === 'keenthemes'"
                  :icon-name="menuItem.keenthemesIcon"
                  icon-class="fs-2"
                />
              </span>
              <span class="menu-title">{{
                translate(menuItem.sectionTitle)
              }}</span>
              <span class="menu-arrow"></span>
            </span>
            <div
              class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px"
            >
              <template v-for="(menuItem1, k) in menuItem.sub" :key="k">
                <div
                  v-if="menuItem1.sectionTitle"
                  data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                  data-kt-menu-placement="right-start"
                  class="menu-item menu-lg-down-accordion"
                >
                  <span
                    v-if="menuItem1.route"
                    class="menu-link py-3"
                    :class="{ active: hasActiveChildren(menuItem1.route) }"
                  >
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{
                      translate(menuItem1.sectionTitle)
                    }}</span>
                    <span class="menu-arrow"></span>
                  </span>
                  <div
                    class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg py-lg-4 w-lg-225px"
                  >
                    <template v-for="(menuItem2, l) in menuItem1.sub" :key="l">
                      <div class="menu-item">
                        <a
                          v-if="menuItem2.route && menuItem2.heading"
                          class="menu-link py-3"
                          :class="{ active: isMenuItemActive(menuItem2.route) }"
                          :href="menuItem2.route"
                        >
                          <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                          </span>
                          <span class="menu-title">{{
                            translate(menuItem2.heading)
                          }}</span>
                        </a>
                      </div>
                    </template>
                  </div>
                </div>
                <div v-if="menuItem1.heading && checkRoutePermission(menuItem1.permission)" class="menu-item">
                  <a
                    v-if="menuItem1.route"
                    class="menu-link"
                    :class="{ active: isMenuItemActive(menuItem1.route) }"
                    :href="menuItem1.route"
                  >
                    <span class="menu-bullet">
                      <span class="bullet bullet-dot"></span>
                    </span>
                    <span class="menu-title">{{
                      translate(menuItem1.heading)
                    }}</span>
                  </a>
                </div>
              </template>
            </div>
          </div>
          <div v-if="menuItem.heading" class="menu-item">
            <router-link
              v-if="menuItem.route && menuItem.route"
              class="menu-link"
              :class="{ active: isMenuItemActive(menuItem.route) }"
              :to="menuItem.route"
            >
              <span class="menu-icon">
                <KTIcon icon-name="element-8" icon-class="fs-2" />
              </span>
              <span class="menu-title">{{ translate(menuItem.heading) }}</span>
            </router-link>
          </div>
        </template>
      </div>
    </div>
  </template>

</template>

<script lang="ts">
import { getAssetPath } from "@/Core/helpers/Assets";
import { defineComponent } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import MainMenuConfig from "@/Layouts/default-layout/config/MainMenuConfig";
import { headerMenuIcons } from "@/Layouts/default-layout/config/helper";
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
export default defineComponent({
  name: "KTMenu",
  components: {},
  setup() {
    const { t, te } = useI18n();
    const route = useRoute();

    // const hasActiveChildren = (match: string) => {
    // //   return route.path.indexOf(match) !== -1;
    //   if(route) {
    //     return route.path.indexOf(match) !== -1;
    //   } else {
    //     return false;
    //   }
    // };



    const translate = (text: string) => {
      if (te(text)) {
        return t(text);
      } else {
        return text;
      }
    };

    const url = window.location.pathname;
    const isMenuItemActive = (route: string) => {
        return url.includes(route) || url.split('/').some(part => part === route);
        // return url === route;
    };

    const hasActiveChildren = (routes: string|string[]|undefined) => {
        routes = routes ?? [];
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
        return allPermissions.some((element: any) => {
            return menuPermissions.some((menuPermission: any) => {
                return element.name === menuPermission
            });
        });
    }

    return {
      hasActiveChildren,
      headerMenuIcons,
      MainMenuConfig,
      translate,
      isMenuItemActive,
      checkRoutePermission,
      checkMenuPermission,
      getAssetPath,
    };
  },
});
</script>

