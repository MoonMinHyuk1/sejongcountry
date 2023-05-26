package com.example.test30.domain.check_user

import retrofit2.Call
import retrofit2.http.Field
import retrofit2.http.FormUrlEncoded
import retrofit2.http.GET
import retrofit2.http.POST

interface CheckUserInterface {

    @FormUrlEncoded
    @POST("InsertCheckUser.php")
    fun insertCheckUser(
        @Field("userId") userId: String
    ): Call<String>

    @FormUrlEncoded
    @POST("DeleteCheckUser.php")
    fun deleteCheckUser(
        @Field("userId") userId: String
    ): Call<String>

    @GET("SelectCheckUser.php")
    fun selectCheckUser(

    ): Call<String>

}