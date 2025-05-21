<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateRoomForm from './Partials/CreateRoomForm.vue';
import { Head } from '@inertiajs/vue3';
import MyRoom from './Partials/MyRoom.vue';

const props = defineProps({
  rooms: {
    type: Object,
  }
});

</script>

<template>

  <Head title="Room" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Room
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <CreateRoomForm class="max-w-xl" />
        </div>

        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <MyRoom class="max-w-xl" :rooms="rooms"/>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
