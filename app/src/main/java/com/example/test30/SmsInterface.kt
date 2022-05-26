package com.example.test30

import retrofit2.Call
import retrofit2.http.Field
import retrofit2.http.FormUrlEncoded
import retrofit2.http.POST

interface SmsInterface {

    @FormUrlEncoded
    @POST("SendSms.php")
    fun sendSms(
        @Field("userId") userId: String
    ): Call<String>

}