<form method="POST" class="content-password-form">
    @csrf
    @error('password')
    <p class="invalid-content-password">
        {{ DzHelper::theme_lang($message) }}
    </p>
    @enderror
    <p>{{ DzHelper::theme_lang('This content is password protected. To view it please enter your password below:') }}</p>
    <p>
        <label for="content-password">
            {{ DzHelper::theme_lang('Password') }}
            <input id="content-password" type="password" class="form-control" required name="password">
        </label>
        <button type="submit">{{ DzHelper::theme_lang('Submit') }}</button>
    </p>
</form>
