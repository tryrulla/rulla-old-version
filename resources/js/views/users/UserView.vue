<template>
  <div v-if="error">
    {{ error }}
  </div>

  <div v-else-if="!loaded">
    Loading...
  </div>

  <div v-else>
    <div class="card-header">
      <div>
        <router-link :to="{ name: 'users.index' }">
          User
        </router-link>

        <span>
          /
          <b>{{ user.identifier }}</b>
        </span>
      </div>

      <h1>
        {{ user.name }}
      </h1>
    </div>

    <details open>
      <summary>Basic details</summary>

      <div class="md:flex">
        <div class="md:w-1/2">
          <table class="table columned">
            <tr>
              <th class="w-1/4">
                Row type
              </th>

              <td class="w-3/4">
                User
              </td>
            </tr>

            <tr>
              <th>
                Identifier
              </th>

              <td>
                {{ user.identifier }}
              </td>
            </tr>

            <tr>
              <th>
                Name
              </th>

              <td>
                <editable-text-field
                  id="name"
                  name="Name"
                  :initial-value="user.name"
                  :save-value="edit"
                />
              </td>
            </tr>

            <tr>
              <th class="w-1/4">
                Username
              </th>
              <td>
                {{ user.username }}
              </td>
            </tr>

            <tr>
              <th class="w-1/4">
                Email
              </th>
              <td>
                {{ user.email }}
              </td>
            </tr>
          </table>
        </div>

        <div class="md:w-1/2">
          <table class="table columned">
          </table>
        </div>
      </div>
    </details>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapState } from 'vuex';
import EditableTextField from '../../components/editing/EditableTextField.vue';
import EditableSelect from '../../components/editing/EditableSelect.vue';

export default {
  components: {
    EditableSelect, EditableTextField,
  },
  computed: {
    id() {
      return parseInt(this.$route.params.user || '1', 10);
    },
    ...mapGetters([
      'apiBaseUrl',
    ]),
    ...mapState({
      error: ({ user }) => user.error,
      loaded: ({ user }) => user.loaded,
      user: ({ user }) => user.user,
    }),
  },
  watch: {
    $route() {
      this.load({ id: this.id });
    },
  },
  mounted() {
    this.load({ id: this.id });
  },
  methods: {
    reload() {
      this.load({ id: this.id });
    },
    ...mapActions({
      load: 'user/load',
      edit: 'user/edit',
    }),
  },
};
</script>
