<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const roomNameInput = ref(null);

const form = useForm({
  name: '',
});

const createRoom = () => {
  form.post(route('room.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      roomNameInput.value.focus();
    },
    onError: () => {
      if (form.errors.name) {
        // form.reset('name');
        roomNameInput.value.focus();
      }
    },
  });
};
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900">
        Create Room
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        Create your own new Chat Room and start connecting with others instantly.
      </p>
    </header>

    <form @submit.prevent="createRoom" class="mt-6 space-y-6">
      <div>
        <InputLabel for="name" value="Room Name" />

        <TextInput id="name" type="text" ref="roomNameInput" class="mt-1 block w-full" v-model="form.name" required
          autofocus autocomplete="name" />

        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
            Created.
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
