package com.example.test30.domain.firebase

import android.app.Application
import androidx.lifecycle.AndroidViewModel
import androidx.lifecycle.viewModelScope
import com.example.test30.domain.notification.model.NotificationBody
import kotlinx.coroutines.launch

class FirebaseViewModel(application: Application) : AndroidViewModel(application) {

    private val repository : FirebaseRepository = FirebaseRepository()
    val myResponse = repository.myResponse
    val userDTO = repository.userDTO

    fun profileLoad(uid : String) {
        repository.profileLoad(uid)
    }

    fun sendNotification(notification: NotificationBody) {
        viewModelScope.launch {
            repository.sendNotification(notification)
        }
    }

}