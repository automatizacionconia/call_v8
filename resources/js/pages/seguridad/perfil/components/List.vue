<template>
  <div>
    <v-row>
        <v-col
          cols="12"
          sm="12"
          md="8"
        >
        <div class="chips-container">
        <v-text-field
              label="Ingresa el nombre o el valor de la propiedad"
              outlined
              dense
              hide-details
              v-model="inputFilter" 
              ref="filterInput"
              @keydown="openPropiedad"
              @focus="showSuggestions"
              @blur="handleBlur"
              @keydown.enter="hideSuggestions"
          ></v-text-field>

            <div v-for="selectedItem in selectedItems" :key="selectedItem.id" class="chip">
              <small>{{ selectedItem.propiedad_name }} : </small><small class="font-weight-bold">{{ selectedItem.label }}</small>
              <span @click="removeSelectedItem(selectedItem.id)" class="close-btn">×</span>
            </div>

          </div>

            <div v-show="suggestionsVisible" id="suggestions" @click="handleSuggestionsClick">
              <div class="list-group">
                <span>Propidades</span>
                <hr class="mb-3">
                  <button 
                  type="button" 
                  class="list-group-item" 
                  v-for="items in itemsPropiedades" 
                  :key="items.id" 
                  @click="getPropiedad(items)">{{ items.name }}</button>
              </div>
          </div>

        </v-col>
      </v-row>

    <!-- <div class="row pa-11">
      
          <div class="row">
              <div class="col-lg-12 col-12 mb-lg-0">
                  <div class="ui-widget">
                    <div class="chips-container">
                      <input type="text" class="form-control" 
                        placeholder="Ingresa el nombre o el valor de la propiedad" 
                        v-model="inputFilter" 
                        ref="filterInput"
                        @keydown="openPropiedad"
                        @focus="showSuggestions"
                        @blur="handleBlur"
                        @keydown.enter="hideSuggestions"
                      >
                      <div v-for="selectedItem in selectedItems" :key="selectedItem.id" class="chip">
                        <small>{{ selectedItem.propiedad_name }} : </small><small class="font-weight-bold">{{ selectedItem.label }}</small>
                        <span @click="removeSelectedItem(selectedItem.id)" class="close-btn">×</span>
                      </div>
                      
                    </div>
                  </div>
              </div>
          </div>
          <div v-show="suggestionsVisible" id="suggestions" @click="handleSuggestionsClick">
            <div class="list-group">
              <span>Propidades</span>
              <hr class="mb-3">
                <button 
                type="button" 
                class="list-group-item" 
                v-for="items in itemsPropiedades" 
                :key="items.id" 
                @click="getPropiedad(items)">{{ items.name }}</button>
            </div>
          </div>
    </div> -->
  </div>
</template>

<script>
  export default {
    data: () => ({
      model: [],
      inputFilter: '',
      suggestionsVisible: false,
      selectedItems: [],
      nextId: 1,

      itemsPropiedades: [
        { id: 1, name: 'Nombres' },
        { id: 2, name: 'Celular' },
        { id: 3, name: 'Planilla' },
        { id: 4, name: 'Menu' },
      ],
      selectedPropiedades: [],
    }),
    methods: {
    openPropiedad() {
      console.log('openPropiedad');
      this.showSuggestions();
    },
    showSuggestions() {
      console.log('showSuggestions');
      this.suggestionsVisible = true;
    },
    hideSuggestions() {

      const parts = this.inputFilter.split(':');
      if(this.inputFilter != '' && this.inputFilter.includes(':') && parts[1].trim() !== ''){

        const newItem = {
                        id: this.nextId++, 
                        label: `${parts[1].trim()}`,
                        propiedad: this.selectedPropiedades.id,
                        propiedad_name: this.selectedPropiedades.name,
                      };
        this.selectedItems.push(newItem);
        this.inputFilter = ''
      }else{
        console.log('Las consultas de filtro con claves deben tener un valor');
      }
      setTimeout(() => {
        this.suggestionsVisible = true;
      }, 300);
    },
    handleBlur(){
      console.log('handleBlur');
      setTimeout(() => {
        this.suggestionsVisible = false;
      }, 200);
    },
    getPropiedad(item) {
      this.selectedPropiedades = item;
      this.inputFilter = `${this.selectedPropiedades.name}:`;
      
      this.$nextTick(() => {
        this.$refs.filterInput.focus();
      });
    },
    removeSelectedItem(itemId) {
      this.selectedItems = this.selectedItems.filter((item) => item.id !== itemId);
    },
    handleSuggestionsClick(event) {
      event.stopPropagation();
    },
    }
  }
</script>

<style scoped>
  .form-control{
    display: block;
    padding: 0.4rem 1rem;
    font-size: .8125rem;
    font-weight: 400;
    line-height: 1.5;
    color: #000444;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #e8ebf3;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    width: 26%;
    -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
  }
  #suggestions {
        box-shadow: 2px 2px 8px 0 rgb(0 0 0 / 20%);
        height: auto;
        position: absolute;
        top: 58px;
        z-index: 9999;
        width: 15%;
        border-radius: 4px;
        overflow: auto;
        background: #fff;
        padding: 7px 4px;
        font-size: 12px;
        color: #737270;
        left: 10px;
    }

    #suggestions .suggest-element {
        background-color: #EEEEEE;
        border-top: 1px solid #d6d4d4;
        cursor: pointer;
        padding: 8px;
        width: 100%;
        float: left;
    }
    #suggestions .list-group-item {
      cursor: pointer;
    }

    #suggestions .list-group-item:hover{
        background-color: rgb(15, 158, 224);
        color: #ffffff;
    }

    .list-group {
      display: flex;
      flex-direction: column;
      padding-left: 0; 
      margin-bottom: 0;
    }
    .list-group-item {
      position: relative;
      display: block;
      text-align: left;
      border-bottom: 1px solid rgba(0,0,0,.125);
    }
    
    .chips-container {
      display: flex;
      flex-wrap: wrap;
    }

    .chip {
      background-color: #ddd;
      border-radius: 13px;
      padding: 4px 8px;
      margin: 4px;
      display: flex;
      align-items: center;
      font-size: 15px;
    }

    .close-btn {
      cursor: pointer;
      margin-left: 4px;
      font-weight: bold;
      background: #3b3636;
      border-radius: 15px;
      padding: 0 6px 1px;
      font-size: 11px;
      color: #fff;
    }
    .ui-widget{
      background: #fff;
    }
</style>
