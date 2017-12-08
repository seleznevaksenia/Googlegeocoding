<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Form<router-link class="pull-right" :to="{ path: '/'}">
                        <span class="glyphicon glyphicon-home"></span></router-link>
                    </div>

                    <div class="panel-body">
                        <form method="POST" action="#">
                            <div class="form-group ">
                                <label for="address">Address</label>
                                <input type="text" name="user_id" class="form-control" id="address"
                                       v-model=address
                                       placeholder="Address" required>
                            </div>
                            <div class="form-group">
                                <label for="language">Select language</label>
                                <select class="form-control" id="language" v-model="language">
                                    <option v-for="item in languages" :value="item.key">{{item.value}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-inline"><input type="checkbox" @change="getformatted" value=""
                                                                      id="formatted">formatted Address</label>
                            </div>
                            <button type="submit" @click.prevent="getCoord" class="btn btn-default btn-block">
                                Get Response
                            </button>
                        </form>
                            <label>Result:</label>
                            <div class="list-group" v-if="response !== ''">
                                <ul  class="list-group">
                                  <li class="list-group-item">longitude:{{longitude}}</li>
                                  <li class="list-group-item">latitude:{{latitude}}</li>
                                  <li  v-if="response.formattedAddress !== null" class="list-group-item">address:{{address_}}</li>
                                </ul>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                address: '',
                languages: {
                    0: {
                        'key': 'ar',
                        'value': 'Arabic'
                    },
                    1: {
                        'key': 'de',
                        'value': 'German'
                    },
                    2: {
                        'key': 'en',
                        'value': 'English'
                    },
                    3: {
                        'key': 'fr',
                        'value': 'French'
                    }
                },
                response: '',
                language: '',
                formatted: false
            }
        },
        computed: {
            longitude() {
              return this.response.longitude;
            },
            latitude() {
                return this.response.latitude;
            },
            address_() {
                return  this.response.formattedAddress;
            },
        },
        created() {
            this.language = 'en';
        },
        methods: {
            getCoord() {
                axios.get('/geo/?language=' + this.language + '&address=' + this.address + '&formatted=' + this.formatted)
                    .then(({data}) => {
                            this.response = data;
                        }
                    );
            },
            getformatted() {
                if ($('#formatted').is(':checked')) {
                    this.formatted = true;
                }
                else {
                    this.formatted = false;
                }
            }
        }
    }
</script>
