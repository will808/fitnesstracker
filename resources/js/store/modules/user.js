import axios from 'axios'

const state = {

    token: localStorage.getItem('current_token') || null,
    user: {},
    dailyIntake: {},
    currentIntake: {},
    dailyActivities: {}
};
const getters = {
    currentUser(state) {
        return state.user
    },
    dailyIntake(state) {
        return state.dailyIntake
    },
    currentIntake(state) {
        return state.currentIntake
    },
    dailyActivities(state) {
        return state.dailyActivities
    },
    token(state) {
        return state.token
    },

    loggedIn(state) {
        return state.token !== null
    }
}



const actions = {
    async fetchUser({commit}) {
        return new Promise((resolve, reject) => {
            var bearerAuth = 'Bearer ' + state.token;
            axios.get("api/user", {
                'headers': {
                    'Authorization': bearerAuth } }).
            then(response => {
                    commit('setUser', response.data);
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                })

        })

    },

    async fetchDailyIntake({
        commit
    }) {



        return new Promise((resolve, reject) => {
            var bearerAuth = 'Bearer ' + state.token;
            axios.get("api/dailyintake", {
                'headers': {
                    'Authorization': bearerAuth
                }
            }).
            then(response => {


                    commit('setDailyIntake', JSON.parse(response.request.response)[0]);
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                })

        })

    },
    async fetchMeals({
        commit
    }) {
        return new Promise((resolve, reject) => {
            var bearerAuth = 'Bearer ' + state.token;
            axios.get("api/meals", {
                'headers': {
                    'Authorization': bearerAuth
                }
            }).
            then(response => {



                    var currentIntake = {
                        calories: 0,
                        carbohydrate: 0,
                        protein: 0,
                        fat: 0,
                    };

                    var meals = response.data;


                    for (var i in meals) {

                        currentIntake.calories += meals[i].calories;
                        currentIntake.carbohydrate += meals[i].carbohydrate;
                        currentIntake.protein += meals[i].protein;
                        currentIntake.fat += meals[i].fat;

                    }










                    commit('setCurrentIntake', currentIntake);
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                })

        })

    },




    getToken({
        commit
    }, userData) {



        return new Promise((resolve, reject) => {
            axios.post('http://localhost/FitnessTracker/public/api/signIn', {
                    email: userData.username,
                    password: userData.password,
                })
                .then(response => {
                    const token = response.data.access_token
                    localStorage.setItem('current_token', token)
                    commit('getToken', token)
                    resolve(response)
                })
                .catch(error => {
                    console.log(error)
                    reject(error)
                })
        })
    },
    register(context, data) {
        return new Promise((resolve, reject) => {
            axios.post('http://localhost/FitnessTracker/public/api/register', {
                    name: data.name,
                    email: data.email,
                    password: data.password,
                })
                .then(response => {


                    resolve(response)
                })
                .catch(error => {


                    reject(error)
                })
        })
    },

    async fetchActivities({
        commit
    }) {



        return new Promise((resolve, reject) => {
            var bearerAuth = 'Bearer ' + state.token;
            axios.get("api/activities", {
                'headers': {
                    'Authorization': bearerAuth
                }
            }).
            then(response => {

                    var dailyActivities = {
                        caloriesBurned: 0,
                    };



                    var activities = response.data;


                    for (var i in activities) {
                        dailyActivities.caloriesBurned += activities[i].caloriesBurned;
                    }



                    commit('setDailyActivities', dailyActivities);
                    resolve(response)
                })
                .catch(error => {
                    reject(error)
                })

        })

    },





    updateUserData(context, data) {

        return new Promise((resolve, reject) => {
            var bearerAuth = 'Bearer ' + state.token;
            axios.put('http://localhost/FitnessTracker/public/api/updateUser', data, {
                    'headers': {
                        'Authorization': bearerAuth
                    }
                })
                .then(response => {
                    resolve(response)



                })
                .catch(error => {
                    reject(error)
                })
        })
    },

    deleteToken(context) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

        if (context.getters.loggedIn) {
            return new Promise((resolve, reject) => {
                axios.post('http://localhost/FitnessTracker/public/api/signOut')
                    .then(response => {
                        localStorage.removeItem('current_token')
                        context.commit('deleteToken')
                        resolve(response)

                    })
                    .catch(error => {
                        console.log(error);
                        reject(error)
                    })
            })
        }
    },
};

const mutations = {
    getToken(state, token) {
        state.token = token
    },
    setUser: (state, responseUser) => (state.user = responseUser),
    setDailyIntake: (state, responseDailyIntake) => (state.dailyIntake = responseDailyIntake),
    setCurrentIntake: (state, responseCurrentIntake) => (state.currentIntake = responseCurrentIntake),
    setDailyActivities: (state, responseDailyActivities) => (state.dailyActivities = responseDailyActivities),
    deleteToken(state) {
        state.token = null
    },
};

export default {
    state,
    getters,
    mutations,
    actions
}
