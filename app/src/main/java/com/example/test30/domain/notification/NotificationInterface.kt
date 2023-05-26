package com.example.test30.domain.notification

import retrofit2.Call
import retrofit2.http.Field
import retrofit2.http.FormUrlEncoded
import retrofit2.http.GET
import retrofit2.http.POST

interface NotificationInterface {

    @FormUrlEncoded
    @POST("InsertNotification.php")
    fun insertNotification(
        @Field("notificationName") notificationName: String,
        @Field("notificationDate") notificationDate: String
    ): Call<String>

    @GET("SelectNotification.php")
    fun selectNotification(

    ):Call<String>

}