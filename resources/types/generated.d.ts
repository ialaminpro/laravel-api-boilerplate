declare namespace App.Actions {
export type RegisterNewUserAction = {
};
}
declare namespace App.Data {
export type BlogPostData = {
title: string;
author: string;
date: string;
};
export type UserData = {
uuid: string;
first_name: string;
last_name: string;
phone_number: string;
email: string;
created_at: string;
updated_at: string;
};
}
declare namespace App.Data.v1_0 {
export type CreateTokenData = {
user: any;
password: string;
token_name: string | null;
};
export type LoginData = {
email: string;
password: string;
token_name: string | null;
};
export type RegisterData = {
uuid: string | null;
first_name: string;
last_name: string | null;
photo: string | null;
phone_number: string | null;
email: string;
role_id: App.Enums.RoleEnum | null;
password: string;
status: App.Enums.StatusEnum | null;
created_by: number | null;
};
}
declare namespace App.Enums {
export type RoleEnum = 1 | 2;
export type StatusEnum = 1 | 0;
export type VersionEnum = 'v1.0' | 'v1.1' | 'v2.0';
}
