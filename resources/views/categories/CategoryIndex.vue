<template>
  <div>
    <h1>Categories Listing</h1>
    <button @click="createCategory">Create New Category</button>
    <div v-if="loading">Loading categories...</div>
    <div v-else>
      <div v-if="error">{{ error }}</div>
      <div v-else>
       <!--  showing  parent categories -->
        <div v-for="category in topLevelCategories" :key="category.id">
          <h2>{{ category.name }}</h2>
          <!-- showing subcategories -->
          <div v-if="category.children && category.children.length > 0">
            <h4>Subcategories:</h4>
            <ul>
              <li v-for="childCategory in category.children" :key="childCategory.id">
                {{ childCategory.name }}
           <button @click="editCategory(childCategory.id)">Edit</button>
          <button @click="deleteCategory(childCategory.id)">Delete</button>
              </li>
            </ul>
          </div>
          <button @click="editCategory(category.id)">Edit</button>
          <button @click="deleteCategory(category.id)">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
//original 
const categories = ref([]);
const loading = ref(false);
const error = ref('');

const fetchCategories = async () => {

  try {

    loading.value = true;
    const response = await axios.get('/api/categories');
    console.log(response.data); // Add this line
    categories.value = response.data;

  } catch (err) {

    error.value = `Error fetching categories: ${err.message}`;

  } finally {

    loading.value = false;

  }
};

onMounted(fetchCategories);

const router = useRouter();

const createCategory = () => {

  router.push({ name: 'categories.create' });

};

const editCategory = (id) => {

  router.push({ name: 'categories.edit', params: { id } });

};

const deleteCategory = async (id) => {

  try {

    loading.value = true;
    await axios.delete(`/api/categories/${id}`);
    categories.value = categories.value.filter(c => c.id !== id);

  } catch (err) {

    error.value = `Error deleting category: ${err.message}`;

  } finally {

    loading.value = false;

  }
};

const topLevelCategories = computed(() => {

  return categories.value.filter(category => !category.parent_id);

});
</script>

<style scoped>

</style>
