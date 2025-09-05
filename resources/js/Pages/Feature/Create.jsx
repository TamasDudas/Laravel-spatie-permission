import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextAreaInput from '@/Components/TextAreaInput';
import TextInput from '@/Components/TextInput';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function Create({ feature }) {
  const { data, setData, processing, errors, post } = useForm({
    name: '',
    description: '',
  });

  const createFeature = (e) => {
    e.preventDefault();

    (post(route('feature.store')),
      {
        preserveScroll: true,
      });
  };

  return (
    <AuthenticatedLayout
      header={
        <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
          Create New Feature
        </h2>
      }
    >
      <Head title="Create New Feature" />

      <div className="mb-4 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
        <div className="flex gap-8 p-6 text-gray-900 dark:text-gray-100">
          <form onSubmit={createFeature} className="w-full">
            <div className="mb-8">
              <InputLabel htmlFor="name" value="Name" />

              <TextInput
                id="name"
                className="mt-1 block w-full"
                value={data.name}
                onChange={(e) => setData('name', e.target.value)}
                required
                isFocused
                autoComplete="name"
              />

              <InputError className="mt-2" message={errors.name} />
            </div>
            <div className="mb-8">
              <InputLabel htmlFor="description" value="Description" />

              <TextAreaInput
                id="description"
                className="mt-1 block w-full"
                value={data.description}
                onChange={(e) => setData('name', e.target.description)}
              />

              <InputError className="mt-2" message={errors.description} />
            </div>
            <div className="flex items-center gap-4">
              <PrimaryButton disabled={processing}>Save</PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
