<template>
  <div>
    <h1>Edit Category</h1>
    <form @submit.prevent="handleSubmit">
      <div>
        <label for="category-name">Category Name:</label>
        <input id="category-name" v-model="category.name" placeholder="Category Name" />
      </div>
      <div>
        <label for="parent-category">Parent Category:</label>
        <select id="parent-category" v-model="category.parent_id">
          <option value="" disabled>Select parent category</option>
          <option v-for="categoryOption in categories" :key="categoryOption.id" :value="categoryOption.id">{{ categoryOption.name }}</option>
        </select>
      </div>
      <button type="submit" :disabled="loading">Update Category</button>
      <div v-if="loading">Updating...</div>
      <div v-if="error">{{ error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useRoute } from 'vue-router';
//original 
const categories = ref([]);
const loading = ref(false);
const error = ref('');

const category = ref({
  name: '',
  parent_id: ''
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
const route = useRoute();

const fetchCategoryDetails = async () => {
  try {

    loading.value = true;
    const response = await axios.get(`/api/categories/${route.params.id}`);
    category.value = response.data;

  } catch (err) {

    error.value = `Error fetching category details: ${err.message}`;

  } finally {
    loading.value = false;
  }
};


onMounted(fetchCategoryDetails);

const handleSubmit = async () => {
  loading.value = true;
  error.value = '';

  try {

    await axios.put(`/api/categories/${route.params.id}`, category.value);
    router.push({ name: 'categories.index' });

  } catch (err) {

    error.value = `Error updating category: ${err.message}`;

  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>

</style>