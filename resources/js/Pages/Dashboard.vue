<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  rooms: {
    type: Object,
  }
});

</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <section>
              <header>
                <h2 class="text-lg font-medium text-gray-900">
                  Available Rooms
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                  Start connecting with others instantly by entering a room.
                </p>
              </header>

              <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-5">
                <div v-for="room in rooms" :key="room.id"
                  class="items-center justify-center bg-gray-100 p-4 rounded-lg shadow">
                  <h3 class="text-lg font-semibold text-gray-800">
                    {{ room.name }}
                  </h3>
                  <p class="mt-2 text-sm text-gray-600">
                    Sample description of the room. This can be a brief overview of what the room is about or its
                    purpose.
                  </p>
                  <div class="mt-4">
                    <Link :href="route('room.join', { 'room': room.id })" as="button"
                      class="mt-2 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700 transition duration-200">
                    Join
                    </Link>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
