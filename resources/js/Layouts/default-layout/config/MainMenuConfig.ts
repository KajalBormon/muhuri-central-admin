import type {MenuItem} from "@/Layouts/default-layout/config/types";
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const sidebarMenuConfig: Array<MenuItem> = [
    {
        pages: [
            {
                heading: t('sidebarMenu.dashboard'),
                route: "/dashboard",
                keenthemesIcon: "element-11",
                bootstrapIcon: "bi-app-indicator",
            }
        ],
    },

    {
        heading: t('sidebarMenu.admin'),
        route: "/configurations",
        headingRoutes: ["/configurations", "/roles", "/users", "/permissions", "/companies", "/subscription-plans","/items"],
        headingPermissions: ["can-view-configuration", "can-view-role", "can-view-user", "can-view-permission", "can-view-company", "can-view-subscription-plan","can-view-item"],
        pages: [
            {
                heading: t('sidebarMenu.configuration.menu'),
                route: "/configurations",
                routePermissions: ["can-view-configuration"],
                keenthemesIcon: "setting-2",
                bootstrapIcon: "bi-archive",
            },
            {
                sectionTitle: t('sidebarMenu.userManagement.menu'),
                route: "/users",
                keenthemesIcon: "profile-user",
                bootstrapIcon: "bi-archive",
                routeArray: ["/roles", "/users", "/permissions"],
                routePermissions: ["can-view-role", "can-view-user", "can-view-permission"],
                sub: [
                    {
                        heading: t('sidebarMenu.userManagement.submenu.permissions'),
                        route: "/permissions",
                        permission: "can-view-permission",
                    },
                    {
                        heading: t('sidebarMenu.userManagement.submenu.roles'),
                        route: "/roles",
                        permission: "can-view-role",
                    },
                    {
                        heading: t('sidebarMenu.userManagement.submenu.users'),
                        route: "/users",
                        permission: "can-view-user",
                    },
                ],
            },
            {
                sectionTitle: 'Tenant Management',
                route: "/tenant-permissions",
                keenthemesIcon: "exit-right-corner",
                bootstrapIcon: "bi-archive",
                routeArray: ["/tenant-permissions", "/tenant-roles"],
                routePermissions: ["can-view-tenant-permission", "can-view-tenant-role"],
                sub: [
                    {
                        heading: 'Permissions',
                        route: "/tenant-permissions",
                        permission: "can-view-tenant-permission"
                    },
                    {
                        heading: 'Roles',
                        route: "/tenant-roles",
                        permission: "can-view-tenant-role"
                    }
                ],
            },
            {
                heading: 'Companies',
                route: "/companies",
                routePermissions: ["can-view-company"],
                keenthemesIcon: "bank",
                bootstrapIcon: "bi-archive",
            },
            {
                heading: 'Items',
                route: '/items',
                routePermissions: ["can-view-item"],
                keenthemesIcon: "abstract-24",
                bootstrapIcon: "bi-archive",
            },
            {
                heading: 'Brands',
                route: '/brands',
                routePermissions: ["can-view-brand"],
                keenthemesIcon: "text-bold",
                bootstrapIcon: "bi-archive",
            },
            {
                heading: 'Job Positions',
                route: '/job-positions',
                routePermissions: ["can-view-job-position"],
                keenthemesIcon: "briefcase",
                bootstrapIcon: "bi-archive",
            },
            {
                heading: 'Departure Reasons',
                route: '/departure-reasons',
                routePermissions: ["can-view-departure-reason"],
                keenthemesIcon: "ghost",
                bootstrapIcon: "bi-archive",
            },
            {
                heading: 'Fiscal Years',
                route: "/fiscal-years",
                routePermissions: ["can-view-fiscal-year"],
                keenthemesIcon: "calendar",
                bootstrapIcon: "bi-archive",
            },
            {
                heading: 'Payment Methods',
                route: '/payment-methods',
                routePermissions: ["can-view-payment-method"],
                keenthemesIcon: "credit-cart",
                bootstrapIcon: "bi-archive",
            },
            {
                sectionTitle: 'Subscription',
                route: "/subscription-plans",
                keenthemesIcon: "price-tag",
                bootstrapIcon: "bi-archive",
                routeArray: ["/subscription-plans", "/subscription-plan-features"],
                routePermissions: ["can-view-subscription-plan", "can-view-subscription-plan-feature"],
                sub: [
                    {
                        heading: 'Subscription Plans',
                        route: "/subscription-plans",
                        permission: "can-view-subscription-plan"
                    },
                    {
                        heading: 'Subscription Plan Features',
                        route: "/subscription-plan-features",
                        permission: "can-view-subscription-plan-feature"
                    }
                ],
            }
        ],
    },
];

export default sidebarMenuConfig;
