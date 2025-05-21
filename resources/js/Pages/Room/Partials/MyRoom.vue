<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router, usePage } from '@inertiajs/vue3';

const props = defineProps({
  rooms: {
    type: Object,
    required: true,
  },
});

const goToPage = (url) => {
  router.visit(url, {
    preserveScroll: true,
    preserveState: true,
  });
};

const deleteRoom = (roomId) => {
  if (!confirm('Are you sure you want to delete this room?')) {
    return;
  }
  
  router.delete(route('room.destroy', roomId), {
    preserveScroll: true,
    preserveState: true,
  });
};

</script>

<template>
  <section v-if="props.rooms.data.length > 0">
    <header>
      <h2 class="text-lg font-medium text-gray-900">
        My Rooms
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        Below is the list of chat rooms you have created. You can manage them or create a new one to connect with others
        instantly.
      </p>
    </header>
    <table class="table-auto border-collapse border border-gray-300 w-full mt-4">
      <thead>
        <tr>
          <th class="border border-gray-300 px-4 py-2">Name</th>
          <th class="border border-gray-300 px-4 py-2">Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="room in props.rooms.data" :key="room.id">
          <td class="border border-gray-300 px-4 py-2">{{ room.name }}</td>
          <td class="border border-gray-300 px-4 py-2">
            <PrimaryButton @click="deleteRoom(room.id)"
              class="bg-red-500 hover:bg-red-600 text-white">
              Delete
            </PrimaryButton>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-center mt-4 space-x-2">
      <button v-for="link in rooms.links" :key="link.label" @click="() => link.url && goToPage(link.url)"
        v-html="link.label" :disabled="!link.url" class="px-3 py-1 border rounded" :class="{
          'bg-gray-200': link.active,
          'text-gray-400': !link.url,
        }" />
    </div>
  </section>
  <section v-else>
    <p class="text-sm text-gray-600">
      You have not created any rooms yet. Start by creating a new room to connect with others!
    </p>
  </section>
</template>
