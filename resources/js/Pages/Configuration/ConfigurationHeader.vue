<template>
    <!--begin::Navbar-->
    <div class="card mb-9">
        <div class="card-body pb-0">

            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold flex-nowrap">
                    <li class="nav-item">
                        <Link :href="route('configurations.details')" :class="{ active: isActive('Details') }"
                            class="nav-link text-active-primary me-6">{{ $t('configuration.header.details') }}
                        </Link>
                    </li>
                    <li class="nav-item" v-if="checkPermission('can-edit-configuration')">
                        <Link :href="route('configurations.basicInfo')" :class="{ active: isActive('BasicInfo') }"
                            class="nav-link text-active-primary me-6">{{ $t('configuration.header.basicInfo') }}
                        </Link>
                    </li>
                    <li class="nav-item" v-if="checkPermission('can-edit-configuration')">
                        <Link :href="route('configurations.additionalInfo')" :class="{ active: isActive('AdditionalInfo') }"
                            class="nav-link text-active-primary me-6">{{ $t('configuration.header.additionalInfo') }}
                        </Link>
                    </li>
                    <li class="nav-item" v-if="checkPermission('can-edit-configuration')">
                        <Link :href="route('configurations.contactInfo')" :class="{ active: isActive('ContactInfo') }"
                            class="nav-link text-active-primary me-6">{{ $t('configuration.header.contactInfo') }}
                        </Link>
                    </li>
                    <li class="nav-item" v-if="checkPermission('can-edit-configuration')">
                        <Link :href="route('configurations.globalInfo')" :class="{ active: isActive('GlobalInfo') }"
                            class="nav-link text-active-primary me-6">{{ $t('configuration.header.globalInfo') }}
                        </Link>
                    </li>
                    <li class="nav-item" v-if="checkPermission('can-edit-configuration')">
                        <Link :href="route('configurations.smsService')" :class="{ active: isActive('SmsService') }"
                            class="nav-link text-active-primary me-6">{{ $t('configuration.header.smsService') }}
                        </Link>
                    </li>
                </ul>
            </div>
            <!--end::Navs-->
        </div>
    </div>
    <slot></slot>
    <!--end::Navbar-->
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import { checkPermission } from "@/Core/helpers/Permission";

const props = defineProps({
    activeLink: String,
    configuration: Object
});

const headerActiveLink = props.activeLink;

const isActive = (linkName: String) => {
    return headerActiveLink == linkName;
};
</script>
