<script setup>

const props = defineProps({
  members: {
    type: Array,
    default: () => [],
  },
})

const emit = defineEmits(['select-member'])

const selectMember = (memberId) => {
  emit('select-member', memberId)
}
</script>

<template>
  <section class="hidden w-full sm:block sm:w-1/4 border">
    <ul>
      <li @click="selectMember(member.user_id)" v-for="member in members" :key="member.id"
        class="items-center p-2 border-b hover:cursor-pointer hover:bg-gray-100">
        <div>
          {{ member.user.name }}
        </div>
      </li>
      <li v-if="!members.length" class="p-2 text-gray-500 text-center">
        No members online.
      </li>
    </ul>
  </section>
</template>