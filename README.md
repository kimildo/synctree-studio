# Synctree Studio

## 기본정책
> - 앱이 가장 큰단위
> - 비즈유닛은 앱에 속한다. 비즈유닛간의 연계성은 없다.
> - 오퍼레이터는 통신의 기본단위 개념이다. 팀에 속하며 비즈유닛에 바인딩 시킬 수 있다.
> - 앱, 비즈유닛, 오퍼레이터의 정보값은 DB에 있고, 이를 조합해 Redis에 메타데이터를 생성해 갖고 있다.
> - 비유닛을 저장하면 디비와 Redis의 정보를 갱신하고, 빌드하면 해당 메타데이터를 통해 파일을 생성한다.

## 개발 완료된 기능
> - 비즈유닛에 오퍼레이터를 바인딩하고 오퍼레이터 간의 변수 연계 지원
> - 비즈유닛 파일 생성 기능
> - 오퍼레이터 JSON 형식 지원
> - 오퍼레이터 보안프로토콜 적용
> - 오퍼레이터 바인딩시 Auth 적용
> - ALT 컨트롤 기능 (오퍼레이터 switch case)
> - 오퍼레이터 Async 기능 (예정)
