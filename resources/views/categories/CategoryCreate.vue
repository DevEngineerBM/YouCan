<template>
  <div>
    <h1>Create Category</h1>
    <form @submit.prevent="handleSubmit">
      <div>
        <label for="category-name">Category Name:</label>
        <input id="category-name" v-model="newCategory.name" placeholder="Category Name" />
      </div>
      <div>
        <label for="parent-category">Parent Category:</label>
        <select id="parent-category" v-model="newCategory.parent_id">
          <option value="" disabled>Select parent category</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
        </select>
      </div>
      <button type="submit" :disabled="loading">Create Category</button>
      <div v-if="loading">Creating...</div>
      <div v-if="error">{{ error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
//original 
const categories = ref([]);
const loading = ref(false);
const error = ref('');

const newCategory = ref({
  name: '',
  parent_id:''
});

const fetchCategories = async () => {
  try {

    loading.value = true;
    const response = await axios.get('/api/categories');
    categories.value = response.data;

  } catch (err) {

    error.value = `Error fetching categories: ${err.message}`;

  } finally {
    loading.value = false;
  }
};

onMounted(fetchCategories);

const router = useRouter();

const handleSubmit = async () => {

  loading.value = true;
  error.value = '';

  try {

    const response = await axios.post('/api/categories', newCategory.value);
    newCategory.value = { name: '', parent_id: '' };
    router.push({ name: 'categories.index' });

  } catch (err) {

    error.value = `Error creating category: ${err.message}`;

  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>

</style>