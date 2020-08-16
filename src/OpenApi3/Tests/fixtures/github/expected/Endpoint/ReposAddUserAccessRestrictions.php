<?php

namespace Github\Endpoint;

class ReposAddUserAccessRestrictions extends \Jane\OpenApiRuntime\Client\BaseEndpoint implements \Jane\OpenApiRuntime\Client\Endpoint
{
    protected $owner;
    protected $repo;
    protected $branch;
    /**
    * Protected branches are available in public repositories with GitHub Free and GitHub Free for organizations, and in public and private repositories with GitHub Pro, GitHub Team, GitHub Enterprise Cloud, and GitHub Enterprise Server. For more information, see [GitHub's products](https://help.github.com/github/getting-started-with-github/githubs-products) in the GitHub Help documentation.
    
    Grants the specified people push access for this branch.
    
    | Type    | Description                                                                                                                   |
    | ------- | ----------------------------------------------------------------------------------------------------------------------------- |
    | `array` | Usernames for people who can have push access. **Note**: The list of users, apps, and teams in total is limited to 100 items. |
    *
    * @param string $owner 
    * @param string $repo 
    * @param string $branch branch+ parameter
    * @param array[] $requestBody 
    */
    public function __construct(string $owner, string $repo, string $branch, array $requestBody)
    {
        $this->owner = $owner;
        $this->repo = $repo;
        $this->branch = $branch;
        $this->body = $requestBody;
    }
    use \Jane\OpenApiRuntime\Client\EndpointTrait;
    public function getMethod() : string
    {
        return 'POST';
    }
    public function getUri() : string
    {
        return str_replace(array('{owner}', '{repo}', '{branch}'), array($this->owner, $this->repo, $this->branch), '/repos/{owner}/{repo}/branches/{branch}/protection/restrictions/users');
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null) : array
    {
        if (is_array($this->body) and isset($this->body[0]) and is_array($this->body[0])) {
            return array(array('Content-Type' => array('application/json')), json_encode($this->body));
        }
        return array(array(), null);
    }
    public function getExtraHeaders() : array
    {
        return array('Accept' => array('application/json'));
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Github\Exception\ReposAddUserAccessRestrictionsUnprocessableEntityException
     *
     * @return null|\Github\Model\SimpleUser[]
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        if (200 === $status && mb_strpos($contentType, 'application/json') !== false) {
            return $serializer->deserialize($body, 'Github\\Model\\SimpleUser[]', 'json');
        }
        if (422 === $status && mb_strpos($contentType, 'application/json') !== false) {
            throw new \Github\Exception\ReposAddUserAccessRestrictionsUnprocessableEntityException($serializer->deserialize($body, 'Github\\Model\\ValidationError', 'json'));
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array();
    }
}