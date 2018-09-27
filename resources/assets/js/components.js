import Vue from 'vue'

import Card from '@/components/Card'
import CompilationErrors from '@/components/Metrics/CompilationErrors'
import CompilationsPerDay from '@/components/Metrics/CompilationsPerDay'
import Loader from '@/components/Icons/Loader'
import LoadingCard from '@/components/LoadingCard'
import PartitionMetric from '@/components/Metrics/PartitionMetric'
import TrendMetric from '@/components/Metrics/TrendMetric'

import UsersIndex from '@/views/UsersIndex'
import ClassroomsIndex from '@/views/ClassroomsIndex'
import CoachingClassrooms from '@/views/CoachingClassrooms'
import CreateClassroom from '@/views/CreateClassroom'
import JoinClassroom from '@/views/JoinClassroom'

Vue.component('card', Card)
Vue.component('compilation-errors', CompilationErrors)
Vue.component('compilations-per-day', CompilationsPerDay)
Vue.component('loader', Loader)
Vue.component('loading-card', LoadingCard)
Vue.component('partition-metric', PartitionMetric)
Vue.component('trend-metric', TrendMetric)
Vue.component('users-index', UsersIndex)
Vue.component('classrooms-index', ClassroomsIndex)
Vue.component('coaching-classrooms', CoachingClassrooms)
Vue.component('create-classroom', CreateClassroom)
Vue.component('join-classroom', JoinClassroom)
